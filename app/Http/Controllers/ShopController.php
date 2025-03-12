<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductsRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categoryslug = null, $subcategoryslug = null)
    {
        $CategorySelected = '';
        $subCategorySelected = '';
        $selectedBrands = $request->get('brands', []); // Get selected brands from the request
        $minPrice = $request->get('min_price', 0); // Default minimum price
        $maxPrice = $request->get('max_price', 1000); // Default maximum price

        // Fetch categories, subcategories, and brands
        $categories = Category::with('subcategories')->where('status', 1)->orderBy('name', 'ASC')->get();
        $brands = Brand::where('status', 1)->orderBy('id', 'DESC')->get();

        // Base query for products
        $products = Product::where('status', 1);

        // Filter by category
        if (!empty($categoryslug)) {
            $category = Category::where('slug', $categoryslug)->firstOrFail();
            $products = $products->where('category_id', $category->id);
            $CategorySelected = $category->id;
        }

        // Filter by subcategory
        if (!empty($subcategoryslug)) {
            $subcategory = SubCategory::where('slug', $subcategoryslug)->firstOrFail();
            $products = $products->where('sub_category_id', $subcategory->id);
            $subCategorySelected = $subcategory->id;
        }

        // Filter by selected brands
        if (!empty($selectedBrands)) {
            $products = $products->whereIn('brand_id', $selectedBrands);
        }

        // Filter by price range
        $products = $products->whereBetween('price', [$minPrice, $maxPrice]);

        if(!empty($request->get('search'))){
            $products = $products->where('title','like','%'.$request->get('search').'%');
        }

        // Add sorting logic
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $products = $products->orderBy('price', 'ASC');
                    break;
                case 'price_desc':
                    $products = $products->orderBy('price', 'DESC');
                    break;
                default:
                    $products = $products->orderBy('id', 'DESC'); // Latest
            }
        }
         else {
            // Default sorting
            $products = $products->orderBy('id', 'DESC');
        }
        //dd($request->all());


        // Finalize Product Query
        $products = $products->with('images')->paginate(9);


        return view('front.shop', compact(
            'categories',
            'brands',
            'products',
            'CategorySelected',
            'subCategorySelected',
            'selectedBrands',
            'minPrice',
            'maxPrice',
        ));
    }

    public function product($slug){
        $product = Product::where('slug', $slug)
        ->withCount('product_ratings')
        ->withSum('product_ratings','rating')
        ->with(['images','product_ratings'])
        ->first();

        if (!$product) {
            return redirect()->route('front.product')->with('error', 'Product not found');
        }

        //fetch related products
        $relatedProducts = [];
        if($product->related_products != ''){
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->with('images')->get();
        }

        //average rating cal
        $avgRating = '0.00';
        $avgRatingPer = 0;
        if ($product->product_ratings_count > 0) {
            $avgRating = number_format(($product->product_ratings_sum_rating/$product->product_ratings_count),2);
            $avgRatingPer = ($avgRating*100)/5;
        }

        return view('front.product',compact('product','relatedProducts','avgRating','avgRatingPer'));
    }

    public function saveRating(Request $request,$id){
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'rating' => 'required',
            'comment' => 'required',
        ]);

        $count = ProductsRating::where('email',$request->email)->where('product_id', $request->product_id)->count();
        if($count>0){
            return redirect()->back()->with('error', 'You already rated this product!');
        }

        $saveRating = new ProductsRating;
        $saveRating->product_id = $id;
        $saveRating->username = $request->username;
        $saveRating->email = $request->email;
        $saveRating->comment = $request->comment;
        $saveRating->rating = $request->rating;
        $saveRating->status = 0;
        $saveRating->save();

        return redirect()->back()->with('success', 'Rating submitted successfully!');
    }
}
