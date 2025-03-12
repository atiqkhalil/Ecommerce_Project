<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\forgotpasswordemail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;

class AccountController extends Controller
{
    public function login()
    {
        return view('account.login');
    }

    public function register()
    {
        return view('account.register');
    }

    public function registersave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;

        $user->save();

        return redirect()->route('login')->with('success', 'You Registered Successfully');
    }

    public function loginsave(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credential)) {
            // ✅ First, check if there's an intended URL and redirect to it
            if (session()->has('url.intended')) {
                return redirect(session()->pull('url.intended')); // Redirect and remove from session
            }

            // ✅ Otherwise, redirect based on user role
            if (Auth::user()->role == 0) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role == 1) {
                return redirect()->route('account.profile', ['id' => Auth::id()]);
            }
        }

        return redirect()->route('login')->with('error', 'Invalid email or password.')->withInput($request->only('email'));
    }


    public function profile($id)
    {
        $user = User::with('customerAddress')->find($id);
        return view('account.profile', compact('user', 'id'));
    }

    public function updateprofile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'phone' => 'required',
            'address' => 'nullable|string',
        ]);

        $user = User::with('customerAddress')->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        // Update or create customer address
        if ($user->customerAddress) {
            // Update existing address
            $user->customerAddress->address = $request->address;
            $user->customerAddress->save();
        } else {
            // Create new address record
            $user->customerAddress()->create([
                'address' => $request->address,
            ]);
        }

        return redirect()->route('account.profile', ['id' => Auth::user()->id])->with('success', 'Your personal information has been successfully updated.');
    }

    public function logout()
    {
        Auth::logout();
        Cart::destroy();
        return redirect()->route('front.home');
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        //dd($orders);
        return view('account.order', compact('orders'));
    }

    public function orderdetail($id)
    {
        $user = Auth::user();

        // Fetch the order details
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();

        // Fetch order items along with product images
        $orderItems = OrderItem::where('order_id', $id)
            ->with(['product' => function ($query) {
                $query->with('image');
            }])->get();

        return view('account.orderdetail', compact('order', 'orderItems'));
    }

    public function wishlist()
    {
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->with('product.images')->get();
        return view('account.wishlist', compact('wishlists'));
    }

    public function deletewishlist($id)
    {
        $removewishlist = Wishlist::find($id);
        $removewishlist->delete();
        return redirect()->route('mywishlist', $removewishlist->id)->with('success', 'Your wishlist deleted successfully.');
    }

    public function changepassword(){
        return view('account.changepassword');
    }

    public function updatepassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        if(Hash::check($request->old_password,Auth::user()->password) == false){
            return redirect()->route('account.changepassword',Auth::id())->with('error','Old Password is Incorrect!');
        }

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('account.profile',Auth::id())->with('success','New Password is Changed Successfully!');
    }

    public function forgotpassword(){
        return view('account.forgotpassword');
    }

    public function forgotpasswordprocess(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(60);

        // Delete any existing record for the email
        PasswordResetToken::where('email', $request->email)->delete();

        $password = new PasswordResetToken;
        $password->email = $request->email;
        $password->token = $token;
        $password->created_at = now();
        $password->save();

        $user = User::where('email',$request->email)->first();
        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have request for change password',
        ];
        Mail::to($request->email)->send(new forgotpasswordemail($mailData));

        return redirect()->route('forgotpassword')->with('success','A password reset link has been sent to your email. Please check your inbox.');
    }

    public function resetpassword($token)
    {
    $tokenRecord = PasswordResetToken::where('token', $token)->first();

    if ($tokenRecord == null) {
        return redirect()->route('forgotpassword')->with('error', 'Invalid Token');
    }

    return view('account.resetpassword', ['token' => $token]);
    }


    public function processresetpassword(Request $request){
        $request->validate([
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|min:4|same:new_password',
        ]);

        $token = PasswordResetToken::where('token', $request->token)->first();
        

        $newpassword = User::where('email',$token->email)->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Delete the token to invalidate the reset link
        PasswordResetToken::where('token', $request->token)->delete();

        return redirect()->route('login')->with('success','You have successfully changed your password');
    }
}
