<?php

namespace App\Http\Controllers\API;

use App\Strach;
use App\Trouser;
use App\Language;
use App\FabricType;
use App\Temperature;
use App\DetergentType;
use App\DetergentScent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languageData = Language::all();
        $strachData = Strach::all();
        $temperatureData = Temperature::all();
        $trouserData = Trouser::all();
        $typeData = DetergentType::all();
        $scentData = DetergentScent::all();
        $fabricData = FabricType::all();
        $data['languages'] = $languageData;
        $data['straches'] = $strachData;
        $data['temperatures'] = $temperatureData;
        $data['trousers'] = $trouserData;
        $data['detergenttypes'] = $typeData;
        $data['detergentscents'] = $scentData;
        $data['fabrictypes'] = $fabricData;
        return $data;
    }

    public function products()
    {
        $data = Product::all();
        return $data;
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
        //
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
    }
}
