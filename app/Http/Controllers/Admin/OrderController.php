<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = Order::with('user')->latest();

    if (!empty($request->keyword)) {
        $keyword = $request->keyword;

        // Join the users table to filter by user name
        $orders = $orders->join('users', 'orders.user_id', '=', 'users.id')
            ->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', '%' . $keyword . '%') 
                    ->orWhere('orders.email', 'like', '%' . $keyword . '%') 
                    ->orWhere('orders.id', 'like', '%' . $keyword . '%'); 
            })
            ->select('orders.*'); // Select only orders columns to avoid conflicts
    }        

        $orders =  $orders->paginate(10);
        return view('admin.orders.list',compact('orders'));
    }

    public function details($id){
        $order = Order::with('country')->where('id', $id)->first();
        $orderItems = OrderItem::where('order_id',$id)->get();
        return view('admin.orders.details',compact('order','orderItems'));
    }

    public function changeOrderStatus(Request $request, $orderId){
        $order = Order::find($orderId);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        $message = 'Order status updated successfully';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
