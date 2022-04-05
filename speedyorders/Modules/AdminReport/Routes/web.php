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

Route::group(['prefix' => 'admin/reports', 'middleware' => 'auth:admin', 'as' => 'admin.reports.'], function (): void {
    Route::get('/customer/order', 'AdminReportController@customerOrderIndex')->name('customerorder.index');
    Route::get('/export/order', 'AdminReportController@customerOrderExport')->name('customerorder.export');

    Route::get('/customer/transaction', 'AdminReportController@customerTransactionIndex')->name('customertransaction.index');
    Route::get('/export/transaction', 'AdminReportController@customerTransactionExport')->name('customertransaction.export');

    Route::get('/tax', 'AdminReportController@taxIndex')->name('tax.index');

    Route::get('/show/order/{id}', 'AdminReportController@customerOrderShow')->name('customerorder.show');
    Route::delete('/delete/order/{id}', 'AdminReportController@customerOrderDelete')->name('customerorder.delete');

    Route::get('/show/tax/{id}', 'AdminReportController@taxShow')->name('tax.show');
});
