<?php

namespace App\Http\Controllers;

/*requests */
use App\Http\Requests\StoreOrderRequest;

/*Collections & Resources */
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;

/*Models */
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

/* Actions */
use App\Actions\CreateOrder;

/*Notifications */
use App\Jobs\EmailNewOrder;

/*Helpers */
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(10);
        return new OrderCollection($orders);
    }
    public function show(Order $order)
    {
        return new OrderResource($order);
    }
    public function store(StoreOrderRequest $request, CreateOrder $createOrder)
    {
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'number' => random_int(0, 99999),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'item_count' => $request->item_count,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'payment' => $request->payment,
            'total' => $request->total,
            'note' => $request->note,
        ]);
        $createOrder->execute($order, $request);
        
        dispatch(new EmailNewOrder($order));
        
        return (new OrderResource($order))->additional([
            'status' => 201,
        ]);
    }
}
