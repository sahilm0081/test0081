<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Order;
use App\Product;
use App\OrderProduct;
use DB;
use Exception;

class OrderController extends Controller
{
    public function index(Request $request)
    {
    }
    public function store(Request $request)
    {
        
        $products = $request->product;
        $quantity = $request->quantity;
        $response = array();
        $response['status'] = false;
        $response['data'] = '';
        $validator = Validator::make($request->all(), [
            'orderstatus' => 'required',

        ]);
        if ($validator->fails()) {
            $response['errors'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_status_id' => $request->orderstatus,
                'price' => 0
            ]);
            $orderId = $order->id;
            $i = 0;
            $totalPrice = 0;
            foreach ($products as $product) {
                $productData = Product::find($product);
                OrderProduct::create([
                    'order_id' => $orderId,
                    'product_id' => $product,
                    'quantity' => $quantity[$i],
                    'product_price' => $productData['price']
                ]);
                $totalPrice += $productData['price'] * $quantity[$i];
                $i++;
            }
            Order::where('id', $orderId)
                ->update([
                    'price' => $totalPrice,
                ]);
            DB::commit();
            $response['status'] = true;
        } catch (Exception $e) {
            $response['data'] = $e->getMessage() . ', Line: ' . $e->getLine();
            $response['status'] = false;
            DB::rollback();
        }

        return response()->json($response);
        
    }

    public function show($id)
    {
        //
        $data=Order::with(['status','user','orderProducts'])->where('id',$id)->get();
        return $data;
    }

    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
    }


    
}
