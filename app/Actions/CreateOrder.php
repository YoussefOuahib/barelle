<?php 
namespace App\Actions;

/*requests */
use App\Http\Requests\StoreOrderRequest;

/*models */
use App\Models\Order;

class CreateOrder {
    public function execute($order, $request) {
        $cart = json_decode($request->cart);
        foreach ($cart as $item) {
            $order->product()->attach($item->id, ['price' => $item->price, 'attributes' => $item->attributes, 'quantity' => $item->quantity]);
        }
    }
}