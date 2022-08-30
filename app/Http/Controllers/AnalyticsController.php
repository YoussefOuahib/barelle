<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\User\UserCollection;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;

class AnalyticsController extends Controller
{
    public function analytics()
    {
        $orders = Order::where('created_at', '>=', Carbon::now()->subDays(30))->get(['total', 'created_at']);
        $status = DB::table('orders')
            ->selectRaw('count(id) as number_of_orders, status')
            ->groupBy('status')
            ->get();
        $products = Product::withCount('order')->orderBy('order_count', 'desc')->get(['name', 'order_count']);
        $customers = User::where('created_at', '>=', Carbon::now()->subDays(7))->get('created_at');

        return response()->json([
            'orders' => $orders,
            'status' => $status,
            'products' => $products,
            'customers' => $customers,
        ]);
    }

    public function dashbord()
    {
        $sales_count = Order::count();
        $sales = Order::sum('total');
        $pending_count = Order::status('pending')->count();
        $pending = Order::status('pending')->sum('total');
        $paid_count = Order::paid('yes')->count();
        $paid = Order::paid('yes')->sum('total');
        $orders = Order::take(3)->latest()->get();
        $customers = User::take(3)->latest()->get();

        return response()->json([
            'sales_count' => $sales_count,
            'sales' => $sales,
            'pending_count' => $pending_count,
            'pending' => $pending,
            'paid_count' => $paid_count,
            'paid' => $paid,
            'orders' => new OrderCollection($orders),
            'customers' => new UserCollection($customers),

        ]);
    }

    public function data()
    {

        $completed = Order::where('updated_at', '>=', Carbon::now()->subDay())->status('delivered')->get()->count();
        $all_completed = Order::status('delivered')->get()->count();
        $pending = Order::where('created_at', '>=', Carbon::now()->subDay())->status('pending')->get()->count();
        $all_pending = Order::status('pending')->get()->count();
        $all_customers = User::all()->count();
        $customers = User::where('created_at', '>=', Carbon::now()->subDay())->get()->count();

        return response()->json([
            'completed' => $completed,
            'all_completed' => $all_completed,
            'pending' => $pending,
            'all_pending' => $all_pending,
            'customers' => $customers,
            'all_customers' => $all_customers,
        ]);

    }

    public function notifications()
    {
        return response()->json(Auth::user()->notifications);
    }

}
