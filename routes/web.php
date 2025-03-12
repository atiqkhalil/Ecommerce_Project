<?php

use App\Http\Middleware\ValidUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\admin\DiscountCodeController;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Admin\ProductSubCategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(RedirectIfAuthenticated::class)->group(function () {
    Route::get('/register', [AccountController::class, 'register'])->name('account.register');
    Route::post('/registersave', [AccountController::class, 'registersave'])->name('account.registersave');
    Route::get('/login', [AccountController::class, 'login'])->name('login');
    Route::post('/loginsave', [AccountController::class, 'loginsave'])->name('account.loginsave');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/updateprofile/{id}', [AccountController::class, 'updateprofile'])->name('account.updateprofile');
    Route::get('/myorders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/changepassword', [AccountController::class, 'changepassword'])->name('account.changepassword');
    Route::post('/updatepassword', [AccountController::class, 'updatepassword'])->name('account.updatepassword');
    Route::get('/orderdetails/{id}', [AccountController::class, 'orderdetail'])->name('account.orderdetail');
    Route::resource('discountcode', DiscountCodeController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'details'])->name('orders.detail');
    Route::post('/orders/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
    Route::post('/wishlistsave/{id}',[FrontController::class,'wishlist'])->name('wishlist');
    Route::get('/mywishlist',[AccountController::class, 'wishlist'])->name('mywishlist');
    Route::delete('/deletemywishlist/{id}',[AccountController::class, 'deletewishlist'])->name('deletewishlist');
    Route::get('/adminchangepassword', [SettingController::class, 'adminchangepassword'])->name('account.adminchangepassword');
    Route::post('/adminupdatepassword', [SettingController::class, 'adminupdatepassword'])->name('account.adminupdatepassword');
    Route::post('/saveRating/{id}', [ShopController::class, 'saveRating'])->name('shop.saveRating');

});

Route::post('/logout', [AccountController::class, 'logout'])->name('logout');



Route::get('/',[FrontController::class,'index'])->name('front.home');
Route::get('/page/{slug}',[FrontController::class,'page'])->name('front.page');
Route::get('/page',[FrontController::class,'showpages'])->name('front.showpages');
Route::get('/shop/{categoryslug?}/{subcategoryslug?}',[ShopController::class,'index'])->name('front.shop');
Route::get('/product/{slug}',[ShopController::class,'product'])->name('front.product');
Route::get('/cart',[CartController::class,'cart'])->name('front.cart');
Route::post('/addtocart/{id}',[CartController::class,'addToCart'])->name('front.addToCart');
Route::post('/updateCart',[CartController::class,'updateCart'])->name('front.updateCart');
Route::delete('/deletecart',[CartController::class,'deleteCart'])->name('front.deletecart');
Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');
Route::post('/processCheckout',[CartController::class,'processCheckout'])->name('front.processCheckout');
Route::get('/thankyou/{id}', [CartController::class, 'thankyou'])->name('front.thankyou');
Route::get('/get-shipping-charge', [CartController::class, 'getShippingCharge'])->name('getShippingCharge');
Route::post('/apply-discount',[CartController::class,'applyDiscount'])->name('front.applyDiscount');
Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('front.getCartTotal');
Route::post('/update-shipping', [CartController::class, 'updateShipping'])->name('front.updateShipping');
Route::post('/contact', [FrontController::class, 'sendEmail'])->name('contact.send');


Route::get('admin/login',[LoginController::class,'index'])->name('admin.login'); //admin login

Route::post('admin/authenticate',[UserController::class,'authenticate'])->name('admin.authenticate');

Route::middleware([ValidUser::class])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/logout', [HomeController::class, 'logout'])->name('admin.logout');
    Route::resource('admin/categories',CategoryController::class);
    Route::resource('admin/sub-categories',SubCategoryController::class);
    Route::resource('admin/brand',BrandController::class);
    Route::resource('admin/products',ProductController::class);
    Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');
    Route::get('/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/userdelete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::resource('admin/pages',PageController::class);

});

Route::get('shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
Route::post('shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
Route::get('shipping/edit/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
Route::post('shipping/editsave/{id}', [ShippingController::class, 'editsave'])->name('shipping.editsave');
Route::delete('shipping/delete/{id}', [ShippingController::class, 'delete'])->name('shipping.delete');


Route::get('/forgotpassword',[AccountController::class,'forgotpassword'])->name('forgotpassword');
Route::post('/forgotpasswordprocess',[AccountController::class,'forgotpasswordprocess'])->name('forgotpasswordprocess');
Route::get('/resetpassword/{token}',[AccountController::class,'resetpassword'])->name('resetpassword');
Route::post('/processresetpassword',[AccountController::class,'processresetpassword'])->name('processresetpassword');
