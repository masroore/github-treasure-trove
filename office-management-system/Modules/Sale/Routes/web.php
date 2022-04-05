<?php

use Illuminate\Support\Facades\Route;

Route::prefix('sale')->middleware('auth')->group(function (): void {
    Route::get('/', 'SaleController@index');

    Route::middleware('permission')->group(function (): void {
        Route::resource('sale', 'SaleController');
        Route::post('/invoice-details', 'SaleController@invoiceDetails')->name('invoice.details');
        Route::post('/quotation-to-store', 'SaleController@quotation_to_store')->name('sale.quotation_to_store');
        Route::post('/store-shipping', 'SaleController@storeShipping')->name('store.shipping');
        Route::get('/sale-delete-modal/{id}', 'SaleController@destroy')->name('sale.delete');
    });

    Route::post('/sale_order_details', 'SaleController@orderDetails')->name('get_sale_details');
    Route::get('sale-return-create', 'SaleController@make_return_list')->name('sale.sale_return_list');
    Route::get('sale-return-details/{id}', 'SaleController@return_details')->name('sale.return_detail_show');
    Route::get('sale-print-view/{id}', 'SaleController@print_view')->name('sale.print_view');
    Route::get('sale-challan-print-view/{id}', 'SaleController@challan_print_view')->name('sale.challan_print_view');

    Route::get('/sale-pdf/{id}', 'SaleController@getPdf')->name('sale.pdf');
    Route::get('/sale-challan-pdf/{id}', 'SaleController@getChallanPdf')->name('sale.challan_pdf');

    Route::get('/sale-configurations', 'SaleController@saleConfiguration')->name('sale.configurations');
    //Purchase Return List
    Route::post('/product_add', 'SaleController@storeProduct')->name('sale.product.add');
    Route::get('/sale-return-list', 'SaleController@returnList')->name('sale.return.index')->middleware('permission');
    Route::get('/sale-return/{id}', 'SaleController@saleReturn')->name('sale.return');
    Route::post('/sale-return-update/{id}', 'SaleController@returnItem')->name('sale.return.update');
    Route::get('/sale-return-excelExport', 'SaleController@fileExport')->name('sale.excel');
    Route::post('/customer-details', 'SaleController@customerDetails')->name('customer.details');
    Route::get('/sale-payments/{id}', 'SaleController@payments')->name('sale.payment');
    Route::post('/sale-payments-details', 'SaleController@payments_details_sale')->name('sale.get_sale_payment_details');
    Route::get('/sale-clone/{id}', 'SaleController@cloneSale')->name('sale.clone');
    Route::post('/sale-order-preview', 'SaleController@getPreview')->name('sale.order.preview');
    Route::post('/sale-store-payments/{id}', 'SaleController@savePayment')->name('sale.store.payment');
    Route::get('/sale-send-mail/{id}', 'SaleController@send_mail_quotation')->name('sale.send_mail');
    Route::get('/sale-quotation-convert/{id}', 'SaleController@convertToQuotation')->name('sale.convertTosale');
    Route::get('/sale-due-list', 'SaleController@dueList')->name('sale.due.list');
    Route::post('/item-session-delete', 'SaleController@itemSessionDelete')->name('item.session.delete');

    //Conditional Sale
    Route::get('/conditional-sales-approve/{id}', 'SaleController@statusChange')->name('conditional.sale.approve');
    Route::get('/return-sales-approve/{id}', 'SaleController@returnApprove')->name('return.sale.approve');
    Route::post('/order-sales-receive', 'SaleController@saleOrder')->name('sale.order.receive');
    Route::post('/sale-shipping_info', 'SaleController@shippingInfo')->name('sale.shipping_info');
    Route::post('/sale-item_delete', 'SaleController@itemDestroy')->name('item.delete');
    Route::get('/due/invoice-list', 'SaleController@invoiceList')->name('due.invoice.list');

    Route::post('/product-modal-for-select', 'SaleController@product_modal_for_select')->name('sale.product_modal_for_select');
});
    Route::get('/conditional-sales', 'SaleController@conditionalSale')->name('conditional.sale.index')->middleware('permission');
    Route::resource('conditional-sale', 'SaleController');
