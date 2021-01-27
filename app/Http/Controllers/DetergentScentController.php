<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetergentScent;
use Auth;
use Illuminate\Support\Facades\Validator;

class DetergentScentController extends Controller
{
    //
    public function index()
    {
        //
        $data = DetergentScent::all();
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
        $response = array();
        $response['status'] = false;
        $response['data'] = '';
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);
        if ($validator->fails()) {
            $response['data'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        return DetergentScent::create([
            'name' => $request->name

        ]);
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
        $data = DetergentScent::findOrFail($id);
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
            $response['data'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        return DetergentScent::where('id', $id)
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
        $data = DetergentScent::findOrFail($id);
        if ($data) {
            $data->delete();
        } else {
            return response()->json(['error' => 'Not found'], 403);
        }
        return response()->json(null);
    }
}
