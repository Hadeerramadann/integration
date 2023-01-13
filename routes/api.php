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

Route::group(['middleware'=>'api','namespace'=>'App\Http\Controllers'],function(){
Route::post('payment','paymentcontroller@payment');
Route::post('makeOrderPaymob','paymentcontroller@makeOrderPaymob');
Route::post('getPaymentKeyPaymob','paymentcontroller@getPaymentKeyPaymob');

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
