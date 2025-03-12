<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $totalOrders = Order::where('status','!=','cancelled')->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role',1)->count();
        $totalsale = Order::where('status','!=','cancelled')->sum('grand_total');

        //this month revenue
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');

        $revenueThisMonth = Order::where('status','!=','cancelled')
                        ->whereDate('created_at','>=',$startOfMonth)
                        ->whereDate('created_at','<=',$currentDate)
                        ->sum('grand_total');

        //last month revenue
        $lastmonthstartdate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastmonthenddate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastmonthname = Carbon::now()->subMonth()->endOfMonth()->format('M');

        $revenuelastMonth = Order::where('status','!=','cancelled')
                        ->whereDate('created_at','>=',$lastmonthstartdate)
                        ->whereDate('created_at','<=',$lastmonthenddate)
                        ->sum('grand_total');    
                        
        //last 30 days sale
        $lastThirtydaysStartDate = Carbon::now()->subDays(30)->format('Y-m-d'); 
        
        $revenuelastThirtydays = Order::where('status','!=','cancelled')
                        ->whereDate('created_at','>=',$lastThirtydaysStartDate)
                        ->whereDate('created_at','<=',$currentDate)
                        ->sum('grand_total');

        return view('admin.dashboard',compact('totalOrders','totalProducts','totalCustomers','totalsale','revenueThisMonth','revenuelastMonth','revenuelastThirtydays','lastmonthname'));
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
