<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function index(){
        return view('front.home');
    }

    public function category(){
        $categories = Category::with('subcategories')->where('status',1)->where('showonhome','Yes')->orderBy('name', 'ASC')->get();
        return view('front.home', compact('categories'));
    }


    public function subcategories(){
        $subcategories = SubCategory::with('category')->get();
        return view('front.home',compact('subcategories'));
    }

    public function featuredproduct(){
        $featuredproducts = Product::orderBy('id','DESC')->where('is_featured','Yes')->where('status',1)->with('images')->get();

        $justarrivedproducts = Product::orderBy('id','DESC')->where('status',1)->with('images')->take('8')->get();

        return view('front.home',compact('featuredproducts','justarrivedproducts'));
    }

    public function brands(){
        $brands = Brand::where('status',1)->orderBy('id', 'DESC')->get();
        return view('front.home', compact('brands'));
    }

    public function wishlist(Request $request,$id){
        $wishlistfind = Product::find($id);
        //dd($wishlistfind);

        //Don't saved twice on one product
        $wishlistcount = Wishlist::where(['user_id' => Auth::user()->id,'product_id' => $id])->count();
        
        if($wishlistcount>0){
            return redirect()->route('front.home',$id)->with('error','You have already saved this product!');
        }

        $wishlist = new Wishlist;
        $wishlist->product_id = $id;
        $wishlist->user_id = Auth::user()->id;
        $wishlist->save();
        return redirect()->route('front.home',$id)->with('success','Product Saved in Wishlist Successfully!');
    }

    public function page($slug){
        $page = Page::where('slug',$slug)->first();
        return view('front.page',compact('page'));
    }

    public function showpages(){
        $pages = Page::orderBy('name','ASC')->get();
        return view('front.footer',compact('pages'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $data = $request->all();

        Mail::to('atiqkhalil51@gmail.com')->send(new ContactFormMail($data));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
