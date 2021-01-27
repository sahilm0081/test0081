<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $products=Product::get()->count();
        $users=User::get()->count();
        $orders=Order::get()->count();
        $topOrders=Order::with(['user','status'])->orderBy('id','desc')->get();
        $data['totalProducts']=$products;
        $data['totalUsers']=$users;
        $data['totalOrders']=$orders;
        $data['orders']=$topOrders;
        return $data;
    }
}
