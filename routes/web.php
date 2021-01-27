<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('/app')->group(function () {
    Route::resource('/language', 'LanguageController');
    Route::resource('/strach', 'StrachController');
    Route::resource('/trouser', 'TrouserController');
    Route::resource('/detergenttype', 'DetergentTypeController');
    Route::resource('/detergentscent', 'DetergentScentController');
    Route::resource('/temperature', 'TemperatureController');
    Route::resource('/fabrictype', 'FabricTypeController');
    Route::resource('/user', 'UserController');
    Route::resource('/user/{id}/address', 'UserAddressController');
    Route::resource('/product', 'ProductController');
    Route::resource('/orderstatus', 'OrderStatusController');
    Route::resource('/order', 'OrderController');
    Route::get('/fetchdata', 'OrderController@fetchdata');
    Route::post('/orderupdate/{id}', 'OrderController@updatePaymentId');
    Route::get('/dashboard', 'DashboardController@index');
});

Route::get('/{any}', function () {
    return view('home');
})->where('any', '.*');
