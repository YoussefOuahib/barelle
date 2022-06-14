<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      
        return [
        'id' => $this->id,
        'number' => $this->number,
        'user_id' => $this->user_id,
        'qty' => $this->item_count,
        'address' => $this->address,
        'phone' => $this->phone,
        'email' => $this->email,
        'customer' => $this->first_name . ' ' . $this->last_name,
        'status' => $this->status,
        'payment' => $this->payment,
        'is_paid' => $this->is_paid,
        'total' => $this->total,
        'note' => $this->note,
        'date' => $this->created_at->format('d-m-Y'),
        'products' => ProductResource::collection($this->product),
        'product' => ProductResource::collection($this->product)->implode('name','-'),
        'attributes' => $this->relationLoaded('product') ? $this->product->pluck('pivot.attributes') : 0,





        /*
        'products' => ProductResource::collection($this->whenLoaded('products')),
*/

       
        
        ];
    }
}
