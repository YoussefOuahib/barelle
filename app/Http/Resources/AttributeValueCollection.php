<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeValueCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $attrs = [];
        
        
        $attributes = $this->collection->keyBy('attribute_id')->pluck('attribute')->pluck('name'); 

        $value = $this->collection->mapToGroups(function ($item, $key) {
            return  [$item['attribute_id'] => $item['value']];


        });
      
        $price = $this->collection->mapToGroups(function ($item, $key) {
            return [$item['attribute_id'] => $item['price_variation']];
        });

        $values = $value->each(function($item, $key) {
            return $item->flatten()->implode(',');
        });
        $prices = $price->each(function ($item, $key) {
            return $item->flatten()->implode(',');
        });
     
         
        return [
            'attribute' => $attributes,
            'values' => $values->toArray(),
            'prices' => $prices->toArray(),
        ];
        
    }
}
