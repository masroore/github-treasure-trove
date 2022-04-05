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

Route::group(['prefix' => 'admin/shipping/package', 'middleware' => 'auth:admin', 'as' => 'admin.package.'], function (): void {
    Route::get('/list', 'AdminPackageController@index')->name('index')->middleware('can:list-package');
    Route::get('/create', 'AdminPackageController@create')->name('create')->middleware('can:create-package');
    Route::post('/store', 'AdminPackageController@store')->name('store')->middleware('can:store-package');
    Route::get('/{id}/edit', 'AdminPackageController@edit')->name('edit')->middleware('can:edit-package');
    Route::post('/update/{id}', 'AdminPackageController@update')->name('update')->middleware('can:update-package');
    Route::delete('/delete/{id}', 'AdminPackageController@destroy')->name('delete')->middleware('can:delete-package');
});

Route::group(['prefix' => 'admin/shipping/deliverytime', 'middleware' => 'auth:admin', 'as' => 'admin.deliverytime.'], function (): void {
    Route::get('/list', 'AdminDeliverytimeController@index')->name('index')->middleware('can:list-deliverytime');
    Route::get('/create', 'AdminDeliverytimeController@create')->name('create')->middleware('can:create-deliverytime');
    Route::post('/store', 'AdminDeliverytimeController@store')->name('store')->middleware('can:store-deliverytime');
    Route::get('/{id}/edit', 'AdminDeliverytimeController@edit')->name('edit')->middleware('can:edit-deliverytime');
    Route::post('/update/{id}', 'AdminDeliverytimeController@update')->name('update')->middleware('can:update-deliverytime');
    Route::delete('/delete/{id}', 'AdminDeliverytimeController@destroy')->name('delete')->middleware('can:delete-deliverytime');
});

Route::group(['prefix' => 'admin/shipping/zoneprice', 'middleware' => 'auth:admin', 'as' => 'admin.zoneprice.'], function (): void {
    Route::get('/list', 'AdminZonepriceController@index')->name('index')->middleware('can:list-zoneprice');
    Route::get('/create', 'AdminZonepriceController@create')->name('create')->middleware('can:create-zoneprice');
    Route::post('/store', 'AdminZonepriceController@store')->name('store')->middleware('can:store-zoneprice');
    Route::get('/{id}/edit', 'AdminZonepriceController@edit')->name('edit')->middleware('can:edit-zoneprice');
    Route::post('/update/{id}', 'AdminZonepriceController@update')->name('update')->middleware('can:update-zoneprice');
    Route::delete('/delete/{id}', 'AdminZonepriceController@destroy')->name('delete')->middleware('can:delete-zoneprice');
});

Route::post('/validateprice', 'AdminZonepriceController@checkZonePrice')->name('validateprice');
