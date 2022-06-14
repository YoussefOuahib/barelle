<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'subcategory_id',
        'description',
        'short_description',
        'regular_price',
        'sale_price',
        'shipping_fee',
        'status',
        'image',
        'gallery',

    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function deleteimage()
    {
        Storage::delete($this->image);
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function order()
    {
        return $this->belongsToMany('App\Models\Order', 'order_product')->withPivot('quantity','price', 'attributes');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory');
    }
  
    public function gallery()
    {
        return $this->hasMany('App\Models\Gallery');
    }
    public function attr_values()
    {
        return $this->hasMany('App\Models\AttributeValue');
    }
}
