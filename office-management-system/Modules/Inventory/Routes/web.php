<?php

use Illuminate\Support\Facades\Route;

Route::prefix('inventory')->group(function (): void {
    Route::get('/inventory/cost-of-goods-history', 'InventoryController@cost_of_goods_index')->name('purchase_order.cost_of_goods.index');

    Route::get('/showroom/search', 'ShowRoomController@index')->name('showroom.search_index');

    // Product Movement
    Route::get('/product-movement', 'InventoryController@index')->name('product_movement.index')->middleware('permission');
    Route::post('select-showroom', 'ShowRoomController@changeShowroom')->name('change.showroom');

    //Stock Transfer
    Route::middleware('permission')->group(function (): void {
        Route::resource('/stock-transfer', 'StockTransferController');
        Route::get('/stock-transfer-delete/{id}', 'StockTransferController@destroy')->name('stock-transfer.delete');
    });
    Route::get('/stock-transfer-excel', 'StockTransferController@getExcel')->name('stock-transfer.excel');
    Route::post('/get-products', 'StockTransferController@getProducts')->name('stock.product');
    Route::post('/stock-products', 'StockTransferController@storeProduct')->name('stock.productInfo');
    Route::post('/check-quantity-products', 'StockTransferController@checkQuantity')->name('check.quantity');
    Route::post('/check-quantity-items', 'StockTransferController@checkQuantityEdit')->name('item.quantity');
    Route::get('/stock-transfer-status/{id}', 'StockTransferController@statusChange')->name('stock-transfer.status');
    Route::get('/stock-transfer-send/{id}', 'StockTransferController@sendToHouse')->name('stock-transfer.sent');
    Route::get('/stock-transfer-receive/{id}', 'StockTransferController@stockReceive')->name('stock-transfer.receive');
    Route::get('/stock-product-info', 'StockTransferController@productInfo')->name('stock.product.info');
    Route::post('/product_modal_for_select', 'StockTransferController@product_modal_for_select')->name('stock.product_modal_for_select');
    // ---- End stock transfar-----

    //Stock Report
    Route::get('/stock-report', 'StockTransferController@stockList')->name('stock.report')->middleware('permission');

    //Stock Adjustment
    Route::prefix('stock-adjustment')->group(function (): void {
        Route::middleware('permission')->group(function (): void {
            Route::get('/lists', 'StockAdjustmentController@index')->name('stock_adjustment.index');
            Route::get('/create', 'StockAdjustmentController@create')->name('stock_adjustment.create');
            Route::get('/destroy/{id}', 'StockAdjustmentController@destroy')->name('stock_adjustment.destroy');
            Route::post('/store', 'StockAdjustmentController@store')->name('stock_adjustment.store');
            Route::get('/edit/{id}', 'StockAdjustmentController@edit')->name('stock_adjustment.edit');
            Route::get('/show/{id}', 'StockAdjustmentController@show')->name('stock_adjustment.show');
            Route::post('/{id}/update', 'StockAdjustmentController@update')->name('stock_adjustment.update');

            Route::get('/approve/{id}', 'StockAdjustmentController@statusChange')->name('stock_adjustment.approve');
        });

        Route::post('/check-quantity-products', 'StockAdjustmentController@checkQuantity')->name('stock_adjustment.check.quantity');
        Route::post('/check-quantity-products', 'StockTransferController@productExist')->name('check.existence');
        Route::post('/product_modal_for_select', 'StockAdjustmentController@product_modal_for_select')->name('stock_adjustment.product_modal_for_select');
        Route::post('/product-add', 'StockAdjustmentController@storeProduct')->name('stock_adjustment.product_add');
    });
});

Route::middleware('permission')->prefix('location')->group(function (): void {
    Route::get('/warehouse', 'WareHouseController@index')->name('warehouse.index');
    Route::post('/warehouse/store', 'WareHouseController@store')->name('warehouse.store');
    Route::post('/warehouse/edit', 'WareHouseController@edit')->name('warehouse.edit');
    Route::post('/warehouse/update/{id}', 'WareHouseController@update')->name('warehouse.update');
    Route::get('/warehouse/destroy/{id}', 'WareHouseController@destroy')->name('warehouse.destroy');

    // ShowRoom
    Route::get('/showroom', 'ShowRoomController@index')->name('showroom.index');
    Route::get('/showroom/{id}/details', 'ShowRoomController@show')->name('showroom.show');
    Route::post('/showroom/store', 'ShowRoomController@store')->name('showroom.store');
    Route::post('/showroom/edit', 'ShowRoomController@edit')->name('showroom.edit');
    Route::post('/showroom/update/{id}', 'ShowRoomController@update')->name('showroom.update');
    Route::get('/showroom/destroy/{id}', 'ShowRoomController@destroy')->name('showroom.destroy');
});
Route::get('/warehouse/search', 'WareHouseController@index')->name('warehouse.search_index');

Route::prefix('account')->group(function (): void {

    //Expenses
    Route::get('/expenses/index', 'ExpenseController@index')->name('expenses.index');
    Route::get('/expenses/create', 'ExpenseController@create')->name('expenses.create');
    Route::get('/expenses/{id}/edit', 'ExpenseController@edit')->name('expenses.edit');
    Route::post('/expenses/{id}/update', 'ExpenseController@update')->name('expenses.update');
    Route::post('/expenses/store', 'ExpenseController@store')->name('expenses.store');
    Route::get('/expenses/{id}/destroy', 'ExpenseController@destroy')->name('expenses.destroy');
});
