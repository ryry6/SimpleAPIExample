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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
	Route::get('customers', 'API\CustomerController@index');
	Route::get('customers/{customer}', 'API\CustomerController@show');
	Route::put('customers/{customer}', 'API\CustomerController@update');
	Route::post('customers', 'API\CustomerController@store');
	Route::delete('customers/{customer}', 'API\CustomerController@destroy');
	Route::get('customers/{customer}/bookings', 'API\CustomerController@bookings');

	Route::get('bookings', 'API\BookingController@index');
	Route::get('bookings/{booking}', 'API\BookingController@show');
	Route::put('bookings/{booking}', 'API\BookingController@update');
	Route::post('bookings', 'API\BookingController@store');
	Route::delete('bookings/{booking}', 'API\BookingController@destroy');
});
