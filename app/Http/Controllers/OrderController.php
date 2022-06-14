<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Auth;
use App\Models\User;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Notifications\newOrder;


class OrderController extends Controller
{
    public function index() {
        $orders = Order::paginate(5);
        return new OrderCollection($orders);
    }
    public function show(Order $order) {
        return new OrderResource($order);
    }
    public function store(Request $request) {
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
        $cart = json_decode($request->cart);
        foreach($cart as $item) {
            $order->product()->attach($item->id, ['price' => $item->price, 'attributes' => $item->attributes, 'quantity' => $item->quantity]);
        }
        $user = User::where('role', 'admin')->first();
        $user->notify(new newOrder($order));



        return (new OrderResource($order))->additional([
            'status' => 201
        ]);
    }
}
