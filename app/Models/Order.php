<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Order extends Model
{
    use Notifiable;
    protected $casts = [
        'created_at' => 'datetime: H:i d-m-y',
    ];


    use HasFactory;
    protected $fillable = [
        'user_id',
        'number',
        'first_name',
        'last_name',
        'email',
        'address',
        'item_count',
        'phone',
        'total',
        'status',
        'is_paid',
        'payment',
        'note'
        

    ];
 
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'order_product')->withPivot('quantity','price','attributes');
    }
    

}
