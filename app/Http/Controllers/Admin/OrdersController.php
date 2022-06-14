<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
class OrdersController extends Controller
{
    public function index()
    {
        $payment = request('payment');
        $filterTotal = request('filterTotal');
        $status = request('status');

        $sort_field = 'created_at';
            $sort_direction = 'DESC';
  
        if($filterTotal == 0) {
            $sort_field = 'total';
            $sort_direction = 'ASC';
        }
        elseif($filterTotal == 1) {
            $sort_field = 'total';
            $sort_direction = 'DESC';
        }
        elseif($filterTotal == 2) {
            $sort_field = 'created_at';
            $sort_direction = 'DESC';
        }
        $orders = Order::when($payment, function ($query, $payment) {
            $query->where('payment', $payment);
        })->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->orderBy($sort_field, $sort_direction)->paginate(10);
        return new OrderCollection($orders);

        



    }
    public function update(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status,
            'is_paid' => $request->is_paid,

        ]);
        return response()->json(['status' => 201]);
    }
    public function show(Order $order) {
        return new OrderResource($order);
    }
}
