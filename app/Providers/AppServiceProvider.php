<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::share('categories', Category::orderBy('name', 'ASC')->where('status',1)->get());
        View::share('featuredproducts',Product::orderBy('id','DESC')->where('is_featured','Yes')->where('status',1)->with('images')->get());
        View::share('justarrivedproducts',Product::orderBy('id','DESC')->where('status',1)->with('images')->take('8')->get());
        View::share('products',Product::orderBy('id','DESC')->where('status',1)->with('images')->paginate(9));
        View::share('brands',Brand::where('status',1)->orderBy('id', 'DESC')->get());
        $pages = Page::orderBy('name', 'ASC')->get();
        View::share('pages', $pages);
        
        view()->composer('*', function ($view) {
            // Fetch data for the dashboard
            $totalOrders = Order::where('status', '!=', 'cancelled')->count();
            $totalProducts = Product::count();
            $totalCustomers = User::where('role', 1)->count();
            $totalsale = Order::where('status', '!=', 'cancelled')->sum('grand_total');

            // This month revenue
            $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $currentDate = Carbon::now()->format('Y-m-d');
            $revenueThisMonth = Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', '>=', $startOfMonth)
                ->whereDate('created_at', '<=', $currentDate)
                ->sum('grand_total');

            // Last month revenue
            $lastmonthstartdate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
            $lastmonthenddate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
            $lastmonthname = Carbon::now()->subMonth()->endOfMonth()->format('M');
            $revenuelastMonth = Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', '>=', $lastmonthstartdate)
                ->whereDate('created_at', '<=', $lastmonthenddate)
                ->sum('grand_total');

            // Last 30 days revenue
            $lastThirtydaysStartDate = Carbon::now()->subDays(30)->format('Y-m-d');
            $revenuelastThirtydays = Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', '>=', $lastThirtydaysStartDate)
                ->whereDate('created_at', '<=', $currentDate)
                ->sum('grand_total');

            // Share data with all views
            $view->with([
                'totalOrders' => $totalOrders,
                'totalProducts' => $totalProducts,
                'totalCustomers' => $totalCustomers,
                'totalsale' => $totalsale,
                'revenueThisMonth' => $revenueThisMonth,
                'revenuelastMonth' => $revenuelastMonth,
                'lastmonthname' => $lastmonthname,
                'revenuelastThirtydays' => $revenuelastThirtydays,
            ]);
        });
    }
    }

