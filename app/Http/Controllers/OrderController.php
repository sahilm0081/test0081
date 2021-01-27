<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderProduct;
use App\OrderStatus;
use App\Product;
use App\User;
use Auth;
use DB;
use Exception;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    public function index()
    {
        //
        $data = Order::with('user')->get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $products = $request->product;
        $quantity = $request->quantity;
        $response = array();
        $response['status'] = false;
        $response['data'] = '';
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'orderstatus' => 'required',

        ]);
        if ($validator->fails()) {
            $response['errors'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $request->user,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Order::findOrFail($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = array();
        $response['status'] = false;
        $response['data'] = '';

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $response['errors'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        return Order::where('id', $id)
            ->update([
                'name' => $request->name,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Order::findOrFail($id);
        if ($data) {
            $data->delete();
        } else {
            return response()->json(['error' => 'Not found'], 403);
        }
        return response()->json(null);
    }

    public function fetchData()
    {
        $data['statuses'] = OrderStatus::all();
        $data['products'] = Product::all();
        $data['users'] = User::all();
        return $data;
    }
    public function updatePaymentId(Request $request, $id)
    {
        $response = array();
        $response['status'] = false;
        $response['data'] = '';

        $validator = Validator::make($request->all(), [
            'payment_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response['errors'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        return Order::where('id', $id)
            ->update([
                'payment_id' => $request->payment_id,
            ]);
    }
}
