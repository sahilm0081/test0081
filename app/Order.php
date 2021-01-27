<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\OrderProduct;
use App\OrderStatus;
use App\Product;
class Order extends Model
{
    

    protected $fillable = [
        'price', 
        'user_id', 
        'order_status_id', 
        'payment_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class)->with('product');
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class,'order_status_id','id');
    }
}
