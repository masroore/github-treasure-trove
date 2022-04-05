<?php

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
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/coupons', 'middleware' => 'auth:admin', 'as' => 'admin.coupons.'], function (): void {
    Route::get('/', 'AdminCouponController@index')->name('index')->middleware('can:list-coupon');
    Route::get('/create', 'AdminCouponController@create')->name('create')->middleware('can:create-coupon');
    Route::post('/store', 'AdminCouponController@store')->name('store')->middleware('can:store-coupon');
    Route::get('/{id}/edit', 'AdminCouponController@edit')->name('edit')->middleware('can:edit-coupon');
    Route::post('/update/{id}', 'AdminCouponController@update')->name('update')->middleware('can:update-coupon');
    Route::delete('/delete/{id}', 'AdminCouponController@destroy')->name('delete')->middleware('can:delete-coupon');

    Route::get('/change/status/{id}', 'AdminCouponController@updateCouponStatus')->name('update.status')->middleware('can:edit-product-option');

    Route::group(['prefix' => '/histories', 'as' => 'histories.'], function (): void {
        Route::get('/', 'AdminCouponHistoryController@index')->name('index')->middleware('can:list-coupon-history');
        Route::get('/details/{coupon}', 'AdminCouponHistoryController@couponHistoryDetails')->name('details')->middleware('can:list-coupon-history');
    });
});
