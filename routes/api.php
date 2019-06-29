<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Product End Points
Route::get('products', ['uses' => 'ProductController@getProducts']);
Route::post('product', ['uses' => 'ProductController@postProduct']);
Route::get('product/{productId}', ['uses' => 'ProductController@getProduct']);
Route::put('product/{productId}', ['uses' => 'ProductController@putProduct']);
Route::delete('product/{producttId}', ['uses' => 'ProductController@deleteProduct']);
Route::get('product/img/{producttId}', ['uses' => 'ProductController@viewFile']);


//Order End Points
Route::get('orders', ['uses' => 'OrderController@getOrders']);
Route::post('order/{productId}', ['uses' => 'OrderController@postOrder']);
Route::get('order/{orderId}', ['uses' => 'OrderController@getOrder']);
Route::put('order/{orderId}', ['uses' => 'OrderController@putOrder']);
Route::delete('order/{ordertId}', ['uses' => 'OrderController@deleteOrder']);

//User End Points
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
