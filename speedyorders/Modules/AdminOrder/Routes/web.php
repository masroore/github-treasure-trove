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

Route::group(['prefix' => 'admin/orders', 'middleware' => 'auth:admin', 'as'=>'admin.orders.'], function () {
    Route::get('/', 'AdminOrderController@index')->name('index')->middleware('can:list-order');
    Route::get('/show/{id}', 'AdminOrderController@show')->name('show')->middleware('can:show-order');
    Route::get('/process/{id}', 'AdminOrderController@process')->name('process')->middleware('can:show-order');
    Route::get('/create', 'AdminOrderController@create')->name('create')->middleware('can:create-order');
    Route::post('/store', 'AdminOrderController@store')->name('store')->middleware('can:store-order');
    Route::get('/{id}/edit', 'AdminOrderController@edit')->name('edit')->middleware('can:edit-order');
    Route::post('/update/{id}', 'AdminOrderController@update')->name('update')->middleware('can:update-order');
    Route::delete('/delete/{id}', 'AdminOrderController@destroy')->name('delete')->middleware('can:delete-order');

    Route::get('/change/status/{id}', 'AdminOrderController@updateOrderStatus')->name('update.status')->middleware('can:edit-product-option');

    Route::post('/option/value', 'AdminOrderController@optionValue')->name('product.options')->middleware('can:edit-product');
    Route::post('/package/value', 'AdminOrderController@packageValue')->name('product.packages')->middleware('can:edit-product');
    Route::post('/package/deliverytime', 'AdminOrderController@packageDeliveryTimes')->name('product.deliverytime')->middleware('can:edit-product');

    Route::get('/invoices/{id}', 'AdminOrderController@showOrderInvoices')->name('invoices.show')->middleware('can:edit-product');
    Route::get('/shipping/invoices/{id}', 'AdminOrderController@showOrderShippingInvoices')->name('shipping.invoices.show')->middleware('can:edit-product');
    Route::post('/histories/store', 'AdminOrderController@adminOrderHistoryStore')->name('histories.store')->middleware('can:store-order-histories');

    Route::get('/order', 'AdminOrderController@getOrderData')->name('order');

    Route::post('/step/html', 'AdminOrderController@getStep2Html')->name('steptwo.html')->middleware('can:edit-product');
    Route::post('/step2/process', 'AdminOrderController@processOrder')->name('steptwo.process')->middleware('can:edit-product');

    Route::get('stripe', 'StripePaymentController@stripe')->name('stripe');
    Route::post('stripe-payment', 'StripePaymentController@stripePost')->name('stripe-payment');
});
