<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::with('addresses')->where('id', $request->user()->id)->get();
        return  $data;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required',],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],


        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => false
            ], 422);
        }
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required',],

        ]);
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => false
            ], 422);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $userId = auth()->user()->id;
            $token = auth()->user()->createToken('Personal Access Token')->accessToken;
            return response()->json(['token' => $token, 'userId' => $userId], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
