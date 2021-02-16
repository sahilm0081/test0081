<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\UserAddress;

class UserAddressController extends Controller
{
    
    public function store(Request $request,$id)
    {
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
            'primary'=>$request->primary ?? 0

        ]);
    }

}
