<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('images')->latest();

        if (!empty($request->keyword)) {
            $products = $products->where('title', 'like', '%' . $request->keyword . '%');
        }

        $products =  $products->paginate(6);
        //dd($products);
        return view('admin.products.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        // Add quantity validation if track_qty is 'Yes'
        if (!empty($request->track_qty) && $request->track_qty === 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        // Validate the request
        $validatedData = $request->validate($rules);

        $product = new Product;
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->shipping_returns = $request->shipping_returns;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->status = $request->status;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->brand_id = $request->brand;
        $product->is_featured = $request->is_featured;
        $product->related_products = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';

        $product->save();

        //image upload logic
        $file = $request->file('photo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $request->file('photo')->storeAs('productimages', $fileName, 'public');

        $productImage = new ProductImage;
        $productImage->product_id = $product->id;
        $productImage->image = $filePath;
        $productImage->save();

        return redirect()->route('products.index')->with('success', 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->get();

        //fetch related products
        $relatedProducts = [];
        if($product->related_products != ''){
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->get();
        }

        return view('admin.products.edit', compact('product', 'brands', 'categories', 'subcategories','relatedProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::with('images')->findOrFail($id);
    
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'short_description' => 'nullable|string',
            'shipping_returns' => 'nullable|string',
        ];
    
        // Add quantity validation if track_qty is 'Yes'
        if ($request->track_qty === 'Yes') {
            $rules['qty'] = 'required|numeric';
        }
    
        // Validate the request
        $validatedData = $request->validate($rules);
    
        // Image upload logic
        if ($request->hasFile('photo')) {
            // Check and delete the old image
            if ($product->images->isNotEmpty()) {
                $imagePath = storage_path('app/public/' . $product->images->first()->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }
    
            // Upload the new image
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('productimages', $fileName, 'public');
    
            // Update or create the product image
            $productImage = $product->images->first() ?? new ProductImage(['product_id' => $product->id]);
            $productImage->image = $filePath;
            $productImage->save();
        }
    
        // Update the product attributes
        $product->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'shipping_returns' => $request->shipping_returns,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'track_qty' => $request->track_qty,
            'qty' => $request->track_qty === 'Yes' ? $request->qty : null,
            'status' => $request->status ?? 'active',
            'category_id' => $request->category,
            'sub_category_id' => $request->sub_category,
            'brand_id' => $request->brand,
            'is_featured' => $request->is_featured,
            'related_products' => (!empty($request->related_products)) ? implode(',', $request->related_products) : '',
        ]);
    
        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::with('images')->find($id);

        // Loop through the images and delete the files
        foreach ($product->images as $image) {
            $imagePath = public_path('storage/' . $image->image);

            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }

    public function getProducts(Request $request){
        $temprod = [];
        if($request->term != ""){
            $products = Product::where('title','like','%'.$request->term.'%')->get();

            if($products != null){
                foreach ($products as $product) {
                    $temprod[] = array('id' => $product->id, 'text' => $product->title);
                }
            }
        }

        return response()->json([
            'tags' => $temprod,
            'status' =>true
        ]);
    }
}
