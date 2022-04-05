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

Route::group([
    'as' => 'admin.externalshop.',
    'prefix' => 'admin/externalshop',
    'middleware' => ['auth', 'permission:dashboard.read'],
], function (): void {
    Route::resource('{source}/orders', 'OrderController', ['except' => ['show']]);
    Route::get('orders/{id}/print', 'OrderController@printed')->name('orders.print');
    Route::post('orders/{id}/reload', 'OrderController@reload')->name('orders.reload');
});

Route::get('common/shop/export.xml', 'ExportController@index')
    ->name('externalshop.export.index');
Route::get('shop/export/{type}', 'ExportController@index');     //TODO: deprecated
Route::get('shop/export.xml', 'ExportController@index');        //TODO: deprecated
