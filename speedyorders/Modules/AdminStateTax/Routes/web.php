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

Route::group(['prefix' => 'admin/reports/tax', 'middleware' => 'auth:admin', 'as'=>'admin.reports.tax.'], function () {
    Route::get('/', 'AdminStateTaxController@index')->name('index');
    Route::get('/create', 'AdminStateTaxController@create')->name('create');
    Route::post('/store', 'AdminStateTaxController@store')->name('store');
    Route::get('/{id}/edit', 'AdminStateTaxController@edit')->name('edit');
    Route::post('/update/{id}', 'AdminStateTaxController@update')->name('update');
    Route::delete('/delete/{id}', 'AdminStateTaxController@destroy')->name('destroy');
    Route::get('/change/status/{id}', 'AdminStateTaxController@updateCategoryStatus')->name('update.status');
});
