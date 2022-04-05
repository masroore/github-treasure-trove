<?php

use Illuminate\Support\Facades\Route;

Route::prefix('contact')->group(function (): void {
    Route::get('/supplier/search', 'ContactController@supplier')->name('supplier.search_index');
    Route::get('/supplier/{id}/details', 'ContactController@show')->name('supplier.view');
    Route::get('/customer/search', 'ContactController@customer')->name('customer.search_index');
    Route::get('/customer/details/{id}', 'ContactController@customer_details')->name('customer.view');
    Route::post('/status', 'ContactController@statusChange')->name('contact.update_active_status');

    Route::middleware('permission')->group(function (): void {
        Route::get('/supplier', 'ContactController@supplier')->name('supplier');
        Route::get('/customer', 'ContactController@customer')->name('customer');
        Route::get('/add_contact/{id}/delete', 'ContactController@destroy')->name('add_contact.delete');
        Route::resource('/add_contact', 'ContactController');
    });

    Route::get('/customer/sale-porduct-list/{id}', 'ContactController@customerSaleProductList')->name('customerSaleProductList');
    Route::get('/supplier/purchase-porduct-list/{id}', 'ContactController@supplierPurchaseProductList')->name('supplierPurchaseProductList');

    Route::post('/add-balance/store', 'ContactController@addBalanceCustomer')->name('customer.voucher_recieve.store');
    Route::post('/minus-balance/store', 'ContactController@minusBalance')->name('customer.minus_balance.store');
    Route::post('supplier/add-balance/store', 'ContactController@addBalanceSupplier')->name('supplier.add_balance.store');
    Route::get('/settings', 'ContactController@settings')->name('contact.settings');
    Route::post('/settings', 'ContactController@post_settings');

    Route::get('/csv-upload-create', 'ContactController@contact_csv_upload')->name('contact_csv_upload');
    Route::post('/csv-upload-store', 'ContactController@contact_csv_upload_store')->name('contact_csv_upload_store');
});

Route::get('my-details', 'ContactController@my_details')->name('contact.my_details');
Route::get('my-products', 'ContactController@my_products')->name('contact.my_products');
Route::get('my-details/sale/payment/{id}', 'ContactController@my_payment')->name('contact.my_payment');
Route::post('my-details/sale/payment/{id}', 'ContactController@post_my_payment');

Route::get('invoice', 'ContactController@invoice')->name('contact.invoice');
Route::get('return', 'ContactController@return')->name('contact.return');
Route::get('transaction', 'ContactController@transaction')->name('contact.transaction');
Route::get('profile', 'ContactController@profile')->name('contact.profile');
Route::post('profile', 'ContactController@post_profile')->name('contact.profile');
