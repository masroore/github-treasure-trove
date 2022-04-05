<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'quotation', 'middleware' => ['auth']], function (): void {
    Route::middleware('permission')->group(function (): void {
        Route::resource('quotation', 'QuotationController');
        Route::get('/quotation-delete/{id}', 'QuotationController@destroy')->name('quotation.delete');
    });

    Route::get('/quotation-status-change/{id}', 'QuotationController@statusChange')->name('quotation.status');
    Route::get('/file-download/{name}', 'QuotationController@fileDownload')->name('quotation.file');
    Route::get('/quotation-sale-convert/{id}', 'QuotationController@convertToSale')->name('quotation.convert');
    Route::get('/quotation-order-pdf/{id}', 'QuotationController@getPdf')->name('quotation.order.pdf');
    Route::get('/quotation-order-print-view/{id}', 'QuotationController@print_view')->name('quotation.order.print_view');
    Route::post('/quotation-order-preview', 'QuotationController@getPreview')->name('quotation.order.preview');
    Route::get('/quotation-clone/{id}', 'QuotationController@clone_quotation')->name('quotation.clone');
    Route::get('/quotation-send-mail/{id}', 'QuotationController@send_mail_quotation')->name('quotation.send_mail');
    Route::post('/add-product', 'QuotationController@addProduct')->name('quotation.add_product');
    Route::post('/add-combo-product', 'QuotationController@addComboProduct')->name('quotation.add_combo_product');
    Route::post('/product-modal-for-select', 'QuotationController@product_modal_for_select')->name('quotation.product_modal_for_select');
});
