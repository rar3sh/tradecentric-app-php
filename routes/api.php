<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrdersController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('App\Http\Controllers\Api')->prefix('orders')->group(function () {
    Route::get('/')->uses('OrdersController@index')->name('orders.index');
    Route::get('/{id}')->uses('OrdersController@show')->name('orders.show');
    Route::post('/')->uses('OrdersController@store')->name('orders.store');
    Route::put('/{id}')->uses('OrdersController@update')->name('orders.edit');
    Route::delete('/{id}')->uses('OrdersController@delete')->name('orders.delete');

});
