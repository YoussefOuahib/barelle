<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'attribute_id',
        'value',
        'price_variation',
    ];
    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
