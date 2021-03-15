<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use Auth;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    //
    public function index()
    {
        //
        $userId = Auth::id();
        $data = Place::where('user_id', $userId)->get();
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
            'title' => 'required',
            'description' => 'required',
            'cover_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:10000'

        ]);
        if ($validator->fails()) {
            $response['errors'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        $path = '';
        if (isset($request->cover_image)) {
            $name = $request->cover_image->getClientOriginalName();
            $fileName = $request->cover_image->hashName();
            $path = $request->cover_image->storeAs('uploads', $fileName, 'public');
        }
        return Place::create([
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $path,
            'user_id' => Auth::id(),
            'lat' => $request->lat,
            'lng' => $request->lng


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
        $data = Place::findOrFail($id);
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
            'title' => 'required',
            'description' => 'required',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10000'

        ]);
        if ($validator->fails()) {
            $response['errors'] = $validator->getMessageBag()->toArray();
            return response()->json($response, 422);
        }
        $place = Place::find($id);
        $path = $place->cover_image;

        if (isset($request->cover_image)) {
            $name = $request->cover_image->getClientOriginalName();
            $fileName = $request->cover_image->hashName();
            $path = $request->cover_image->storeAs('uploads', $fileName, 'public');
        }
        return Place::where('id', $id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'cover_image' => $path,
                'lat' => $request->lat,
                'lng' => $request->lng
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
        $data = Place::findOrFail($id);
        if ($data) {
            $data->delete();
        } else {
            return response()->json(['error' => 'Not found'], 403);
        }
        return response()->json(null);
    }
}
