<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Country;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use App\Models\ShippingCharge;
use App\Mail\OrderConfirmation;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Mail\OrderReceivedAdminNotification;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        // Find the product with its images
        $product = Product::with('images')->find($id);

        // If product is not found, redirect with error message
        if (!$product) {
            return redirect()->route('front.product')->with('error', 'Product not found');
        }

        // Check if the product is already in the cart
        $productAlreadyExist = false;
        foreach (Cart::content() as $item) {
            if ($item->id == $product->id) {
                $productAlreadyExist = true;
                break;
            }
        }

        // If the product already exists in the cart, show an "already added" message
        if ($productAlreadyExist) {
            return redirect()->route('front.product', ['slug' => $product->slug])
                ->with('error', $product->title . ' is already in the cart');
        }

        // If the product is not already in the cart, add it to the cart
        Cart::add($product->id, $product->title, 1, $product->price, [
            'productImage' => optional($product->images->first())->image,
            'shortDescription' => $product->short_description
        ]);

        // Redirect with a success message after adding to cart
        return redirect()->route('front.cart', ['slug' => $product->slug])
            ->with('success', $product->title . ' added to cart');
    }

    public function cart()
    {
        $cartContents = Cart::content();
        //dd($cartContents);
        return view('front.cart', compact('cartContents'));
    }


    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);
        //check qty avialbe in stock
        if ($product->track_qty == 'Yes') {
            if ($qty <= $product->qty) {
                // Update cart if the quantity is within stock
                Cart::update($rowId, $qty);
                $message = 'Cart Updated Successfully';
                $status = true;
                session()->flash('success', $message);
            } else {
                // If requested quantity exceeds available stock
                $message = 'Request qty (' . $qty . ') not available in stock.';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            // If stock tracking is not enabled, update the cart directly
            Cart::update($rowId, $qty);
            $message = 'Cart Updated Successfully';
            $status = true;
            session()->flash('success', $message);
        }


        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function deleteCart(Request $request)
    {
        $rowId = $request->rowId;  // Retrieve rowId from the form
        Cart::remove($rowId);  // Remove the item from the cart using the rowId

        session()->flash('success', 'Item removed from cart');
        return redirect()->route('front.cart');  // Redirect back to the cart page
    }

    public function checkout()
    {
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        if (!Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('login');
        }

        $customerAddress = CustomerAddress::where('user_id', Auth::id())->first();

        session()->forget('url.intended');

        $countries = Country::orderBy('name', 'ASC')->get();

        $totalQty = 0;
        $totalShippingCharge = 0;

        // Check if customer has an address before calculating shipping
        if ($customerAddress) {
            $userCountry = $customerAddress->country_id;
            $shippingInfo = ShippingCharge::where('country_id', $userCountry)->first();

            // Calculate shipping charge only if a valid shipping charge exists
            if ($shippingInfo) {
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }
                $totalShippingCharge = $totalQty * $shippingInfo->amount;
            }
        }

        return view('front.checkout', compact('countries', 'totalShippingCharge'));
    }


    public function getShippingCharge(Request $request)
    {
        $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();

        if ($shippingInfo) {
            return response()->json([
                'success' => true,
                'shipping_charge' => $shippingInfo->amount
            ]);
        }

        return response()->json([
            'success' => false,
            'shipping_charge' => 0,
            'message' => 'Shipping charge not found'
        ]);
    }


    public function processCheckout(Request $request)
{
    $request->validate([
        'first_name' => 'required|min:5',
        'last_name' => 'required',
        'email' => 'required|email',
        'country' => 'required',
        'address' => 'required|min:5',
        'city' => 'required',
        'state' => 'required',
        'zip' => 'required',
        'mobile' => 'required',
    ]);

    $user = Auth::user();

    // Save customer address
    CustomerAddress::updateOrCreate(
        ['user_id' => $user->id],
        [
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'country_id' => $request->country,
            'address' => $request->address,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
        ]
    );

    if ($request->payment_method == 'cod') {
        $shipping = 0;
        $subTotal = (float) str_replace(',', '', Cart::subtotal()); // Ensure float value

        // Fetch Shipping Charge
        $shippingInfo = ShippingCharge::where('country_id', $request->country)->first();
        $totalQty = 0;

        if ($shippingInfo) {
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }
            $shipping = $totalQty * $shippingInfo->amount;
        }

        // Calculate Grand Total (Subtotal + Shipping)
        $grandTotal = $subTotal + $shipping;

        // Create Order
        $order = new Order;
        $order->subtotal = $subTotal;
        $order->shipping = $shipping;
        $order->grand_total = $grandTotal;
        $order->payment_status = 'not paid';
        $order->status = 'pending';
        $order->user_id = $user->id;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->address = $request->address;
        $order->apartment = $request->apartment;
        $order->state = $request->state;
        $order->city = $request->city;
        $order->zip = $request->zip;
        $order->notes = $request->notes;
        $order->country_id = $request->country;
        $order->save();

        // Save Order Items
        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem;
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->name = $item->name;
            $orderItem->qty = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;
            $orderItem->save();

            //update product stock
            $productData = Product::find($item->id);
            if ($productData->track_qty == 'Yes') {
                $currentQty = $productData->qty;
                $updateQty = $currentQty-$item->qty;
                $productData->qty = $updateQty;
                $productData->save();
            }
        }

        // Clear Cart
        Cart::destroy();


        // Send Order Confirmation Email
        Mail::to($order->email)->send(new OrderConfirmation($order));

         // Send Order Notification Email to Admin
         $adminEmail = 'atiqkhalil51@gmail.com'; 
         Mail::to($adminEmail)->send(new OrderReceivedAdminNotification($order));

        return redirect()->route('front.thankyou', ['id' => $order->id]);
    }
}



    public function thankyou($id)
    {
        return view('front.thanks', compact('id'));
    }

//     public function applyDiscount(Request $request)
//     {
//         $code = DiscountCoupon::where('code', $request->code)->first();

//         if (!$code) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Invalid discount coupon',
//             ]);
//         }

//         // Check if coupon start date is valid
//         $now = Carbon::now();

//         if (!empty($code->starts_at)) {
//             $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->starts_at);
//             if ($now->lt($startDate)) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Coupon is not valid yet',
//                 ]);
//             }
//         }

//         // Check if coupon expired
//         if (!empty($code->expires_at)) {
//             $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at);
//             if ($now->gt($endDate)) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Coupon has expired',
//                 ]);
//             }
//         }

//         // Store discount in session as an array (avoid saving the model)
//         session()->put('code', [
//             'code' => $code->code,
//             'type' => $code->type,
//             'discount_amount' => $code->discount_amount
//         ]);

//         return response()->json([
//             'status' => true,
//             'message' => 'Discount applied successfully!',
//             'discount' => $code->discount_amount,
//         ]);
//     }

//     public function getCartTotal()
// {
//     $shipping = 0;
//     $discount = 0;
//     $subTotal = (float) str_replace(',', '', Cart::subtotal()); // Ensure proper float conversion

//     // Fetch Shipping Charge
//     if (session()->has('country_id')) {
//         $shippingInfo = ShippingCharge::where('country_id', session('country_id'))->first();
//         if ($shippingInfo) {
//             $totalQty = 0;
//             foreach (Cart::content() as $item) {
//                 $totalQty += $item->qty;
//             }
//             $shipping = $totalQty * $shippingInfo->amount;

//             // ✅ Store Shipping Charge in Session
//             session()->put('shipping', $shipping);
//         }
//     } else {
//         // ✅ If no shipping info found, reset session shipping to 0
//         session()->put('shipping', 0);
//     }

//     // Correct Calculation: First add shipping to subtotal, then apply discount
//     $totalBeforeDiscount = $subTotal + $shipping;

//     // Apply Discount AFTER Adding Shipping
//     if (session()->has('code')) {
//         $code = session()->get('code');

//         if ($code['type'] == 'percent') {
//             $discount = ($code['discount_amount'] / 100) * $totalBeforeDiscount;
//         } else {
//             $discount = min($code['discount_amount'], $totalBeforeDiscount);
//         }
//     }

//     // Final Grand Total (Ensure it is not negative)
//     $grandTotal = max(0, $totalBeforeDiscount - $discount);

//     return response()->json([
//         'subtotal' => number_format($subTotal, 2),
//         'shipping' => number_format($shipping, 2),
//         'total_before_discount' => number_format($totalBeforeDiscount, 2),
//         'discount' => number_format($discount, 2),
//         'grand_total' => number_format($grandTotal, 2),
//     ]);
// }

// public function updateShipping(Request $request)
// {
//     $shipping = 0;

//     if ($request->has('country_id')) {
//         $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();

//         if ($shippingInfo) {
//             $totalQty = 0;
//             foreach (Cart::content() as $item) {
//                 $totalQty += $item->qty;
//             }
//             $shipping = $totalQty * $shippingInfo->amount;

//             // ✅ Store the shipping charge in the session
//             session()->put('shipping', $shipping);
//         } else {
//             session()->put('shipping', 0); // Reset to 0 if no shipping info found
//         }
//     }

//     return response()->json([
//         'shipping' => number_format($shipping, 2),
//         'message' => 'Shipping charge updated successfully.',
//     ]);
// }



    
    
}
