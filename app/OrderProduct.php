<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
class OrderProduct extends Model
{


    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'product_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
