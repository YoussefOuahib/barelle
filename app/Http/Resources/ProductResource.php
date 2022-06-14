<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GalleryResource;
class ProductResource extends JsonResource
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
           'name' => $this->name,
           'slug' => $this->slug,
           'category' => $this->category->name,
           'subcategory' => $this->subcategory->name,
           'regular_price' => $this->regular_price,
           'sale_price' => $this->sale_price,
           'short_description' => $this->short_description,
           'description' => $this->description,
            'image' => $this->image,
            'shipping_fee' => $this->shipping_fee,
            'status' => $this->status,
            'orders' => $this->order->count(),
            'gallery' => GalleryResource::collection($this->gallery),
            /*
            'options' =>  AttributeValueResource::collection($this->attr_values),
            */
            'attributes' => $this->relationLoaded('order') ? $this->order->pluck('pivot.attributes') : 0,
            'quantity' => $this->relationLoaded('order') ? $this->order->pluck('pivot.quantity')->join(' ')  : 0,
            'price' => $this->relationLoaded('order') ? $this->order->pluck('pivot.price') : 0,

            
            /*
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(), 2) : 'NOT RATED',
            'href' => [
                'review' => route('reviews.index', $this->id),
            ],
            */
           
            
        ];
    }
}
