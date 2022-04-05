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

Route::group(['prefix' => 'admin/customers', 'middleware' => 'auth:admin', 'as' => 'admin.customers.'], function (): void {
    Route::get('/', 'AdminCustomerController@index')->name('index')->middleware('can:list-customer');
    Route::get('/create', 'AdminCustomerController@create')->name('create')->middleware('can:create-customer');
    Route::post('/store', 'AdminCustomerController@store')->name('store')->middleware('can:store-customer');
    Route::get('/{id}/edit', 'AdminCustomerController@edit')->name('edit')->middleware('can:edit-customer');
    Route::post('/update/{id}', 'AdminCustomerController@update')->name('update')->middleware('can:update-customer');
    Route::delete('/delete/{id}', 'AdminCustomerController@destroy')->name('delete')->middleware('can:delete-customer');

    Route::get('/address-details/{id}', 'AdminCustomerController@getCustomerAddressDetails')->name('address.details')->middleware('can:get-customer-address-details');

    Route::get('/address-delete/{id}', 'AdminCustomerController@deleteAddressDetails')->name('address.delete')->middleware('can:delete-address-details');

    Route::get('/transaction-details/{id}', 'AdminCustomerController@getCustomerTransactionDetails')->name('transaction.details')->middleware('can:get-customer-transaction-details');
    Route::get('/ip-details/{id}', 'AdminCustomerController@getCustomerIpAddressDetails')->name('ipaddress.details')->middleware('can:get-customer-ipaddress-details');

    Route::get('/change/status/{id}', 'AdminCustomerController@updateCustomerStatus')->name('update.status')->middleware('can:edit-product-option');
});
