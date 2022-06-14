<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\User\UserCollection;
use Auth;
use Carbon\Carbon;
use DB;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
class AnalyticsController extends Controller
{
    public function analytics() {
        $orders = Order::where('created_at', '>=', Carbon::now()->subDays(30))->get(['total','created_at']);
        $status = DB::table('orders')
        ->selectRaw('count(id) as number_of_orders, status')
        ->groupBy('status')
        ->get();
        $products = Product::withCount('order')->orderBy('order_count', 'desc')->get(['name','order_count']);
        $customers = User::where('created_at', '>=', Carbon::now()->subDays(7))->get('created_at');
    
        return response()->json([
            'orders' => $orders,
            'status' => $status,
            'products' => $products,
            'customers' => $customers
        ]);
    }

    public function dashbord() {
        $sales_count = Order::count();
        $sales = Order::sum('total');
        $pending_count = Order::where('status', 'Pending')->count();
        $pending = Order::where('status', 'Pending')->sum('total');
        $paid_count = Order::where('is_paid', 'Yes')->count();
        $paid = Order::where('is_paid', 'Yes')->sum('total');
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
        
        public function data() {
          
            $completed = Order::where('updated_at', '>=', Carbon::now()->subDay())->where('status', 'Delivered')->get()->count();
            $all_completed = Order::where('status', 'Delivered')->get()->count();
            $pending = Order::where('created_at', '>=', Carbon::now()->subDay())->where('status', 'Pending')->get()->count();
            $all_pending = Order::where('status', 'Pending')->get()->count();
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

        public function notifications() {
            $notifications = Auth::user()->notifications;

            return response()->json($notifications);
        }

    
    
}
