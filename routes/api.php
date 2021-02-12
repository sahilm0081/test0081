<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->group(function () {
    Route::post('/login', 'API\UserController@login');
    Route::post('/register', 'API\UserController@store');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/moduledata', 'API\CommonController@index');
Route::get('/products', 'API\CommonController@products');
/* moduledataRoute::middleware('auth:api')->group(function () { */
    
/* }); */
