<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
}
