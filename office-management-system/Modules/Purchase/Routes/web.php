<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'purchase', 'middleware' => ['auth']], function (): void {
    //Purchase Order
    Route::middleware('permission')->group(function (): void {
        Route::resource('/purchase_order', 'PurchaseOrderController');
        Route::post('/purchase_order_details', 'PurchaseOrderController@orderDetails')->name('get_purchase_details');
        Route::get('/purchase-order-delete-modal/{id}', 'PurchaseOrderController@destroy')->name('purchase.order.destroy');

        Route::get('/suggested-list', 'PurchaseOrderController@suggestList')->name('purchase.suggest');
        Route::get('/add-suggest/{id}', 'PurchaseOrderController@suggestCreate')->name('suggest.create');
        Route::get('/convert-to-purchase', 'PurchaseOrderController@convertSuggest')->name('convert.purchase');
        Route::post('/purchase-payment', 'PurchaseOrderController@purchasePayment')->name('purchase.modal.payment');
        Route::post('/supplier-purchase/details', 'PurchaseOrderController@purchaseDetails')->name('supplier.purchase.details');
    });

    Route::post('/add-to-stock', 'PurchaseOrderController@add_to_stock_store')->name('purchase_order.add_to_stock');
    Route::get('purchase-return-details/{id}', 'PurchaseOrderController@return_details')->name('purchase_order.return_detail_show');

    Route::get('/purchase-payments/{id}', 'PurchaseOrderController@payments')->name('purchase.payment');
    Route::post('/purchase-save-payments/{id}', 'PurchaseOrderController@savePayment')->name('purchase.store.payment');
    Route::get('/purchase-order-pdf/{id}', 'PurchaseOrderController@getPdf')->name('purchase.order.pdf');
    Route::get('/purchase-order-print-view/{id}', 'PurchaseOrderController@print_view')->name('purchase.order.print_view');
    Route::get('/purchase-order/mail/{id}', 'PurchaseOrderController@send_mail')->name('purchase.mail');
    Route::get('/purchase-order-fileDownload/{document}', 'PurchaseOrderController@fileDownload')->name('purchase.order.download');
    Route::get('/purchase-order-excelExport', 'PurchaseOrderController@fileExport')->name('purchase.order.excel');
    Route::get('/purchase_approve_modal/{id}', 'PurchaseOrderController@approve')->name('purchase.approve');
    Route::get('/purchase-add-to-stock/{id}', 'PurchaseOrderController@addToStock')->name('purchase.add.stock');
    Route::post('/purchase/receive/{id}', 'PurchaseOrderController@receiveProducts')->name('purchase.receive.update');
    Route::get('/purchase/receive-list/{id}', 'PurchaseOrderController@receiveProductList')->name('purchase.receive.products');
    Route::post('purchase-multiple-payment', 'PurchaseOrderController@multiple_payment_modal')->name('purchase_multiple_payment');

    //Purchase Return List
    Route::middleware('permission')->group(function (): void {
        Route::get('/purchase-return-approve/{id}', 'PurchaseOrderController@returnApprove')->name('return.purchase.approve');
        Route::get('/purchase-return-list', 'PurchaseOrderController@returnList')->name('purchase.return.index');
    });
    Route::post('/purchase-return-update/{id}', 'PurchaseOrderController@returnItem')->name('purchase.return.update');
    Route::get('/purchase-return/{id}', 'PurchaseOrderController@purchaseReturn')->name('purchase.order.return');
    Route::get('/purchase-return-excelExport', 'PurchaseOrderController@returnExport')->name('purchase.return.excel');

    Route::get('/purchase-return-list-create', 'PurchaseOrderController@purchase_return_list')->name('purchases.purchase_return_list');
    //Purchase Order Product Calculation
    Route::post('/product_add', 'PurchaseOrderController@storeProduct')->name('order.product.add');
    Route::post('/combo_product_add', 'PurchaseOrderController@storeComboProduct')->name('order.combo_product.add');
    Route::post('/product_details', 'PurchaseOrderController@productDetails')->name('order.product.details');
    Route::post('/product_quantity', 'PurchaseOrderController@productQuantity')->name('order.product.quantity');
    Route::post('/product_discount', 'PurchaseOrderController@productDiscount')->name('order.product.discount');
    Route::post('/product_tax', 'PurchaseOrderController@productTax')->name('order.product.tax');
    Route::post('/product_delete', 'PurchaseOrderController@itemDelete')->name('order.product.delete');
    Route::post('/product_delete_model', 'PurchaseOrderController@itemDestroy')->name('order.product.destroy');

    //Purchase
    Route::resource('/cnf', 'CNFController');
    Route::post('/cnf-edit-modal', 'CNFController@edit')->name('cnf.edit.modal');
    Route::get('/cnf-destroy/{id}', 'CNFController@destroy')->name('cnf.delete');
});

Route::get('/inventory/purchase-order-recieve', 'PurchaseOrderController@recieve_index')->name('purchase_order.recieve.index');
Route::post('/product-modal-for-select', 'PurchaseOrderController@product_modal_for_select')->name('purchase.product_modal_for_select');
Route::post('/product-filter/supplier', 'PurchaseOrderController@filterProduct')->name('filter.product.supplier');
