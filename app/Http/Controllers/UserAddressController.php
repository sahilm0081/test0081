<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserAddress;
use Auth;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    //
    public function index()
    {
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
    public function store(Request $request, $id)
    {
        //
        $response = array();
        $response['status'] = false;
        $response['data'] = '';
        $validator = Validator::make($request->all(), [
            'bldg_no' => 'required',
            'street_no' => 'required',
            'zone_no' => 'required',
            'street_name' => 'required',
            'landmark' => 'required',
            'area' => 'required',

        ]);
        if ($validator->fails()) {
            $response['errors'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        return UserAddress::create([
            'bldg_no' => $request->bldg_no,
            'street_no' => $request->street_no,
            'zone_no' => $request->zone_no,
            'street_name' => $request->street_name,
            'landmark' => $request->landmark,
            'area' => $request->area,
            'user_id' => $id,

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
       /*  $data = User::with('addresses')->findOrFail($id);
        return $data; */
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $id)
    {
        //
        $data = UserAddress::findOrFail($id);
        if ($data) {
            $data->delete();
        } else {
            return response()->json(['error' => 'Not found'], 403);
        }
        return response()->json(null);
    }
}
