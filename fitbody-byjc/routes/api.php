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

Route::get('/test', function (Request $request) {
    return response()->json('OK je ovdje');
});
// Cart routes.
/*Route::prefix('v1')->group(function () {
    Route::get('/user', 'Api\v1\CartController@getUser')->name('api.user');

    Route::prefix('cart')->group(function () {
        Route::get('/get', 'Api\v1\CartController@get')->name('api.cart.get');
        Route::post('/add', 'Api\v1\CartController@add')->name('api.cart.add');
        Route::post('/update/{id}', 'Api\v1\CartController@update')->name('api.cart.update');
        Route::post('/remove/{id}', 'Api\v1\CartController@remove')->name('api.cart.remove');
    });
});*/
