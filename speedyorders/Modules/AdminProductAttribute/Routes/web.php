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
Route::group(['prefix' => 'admin/attributes', 'middleware' => 'auth:admin', 'as' => 'admin.product.attributes.'], function (): void {
    Route::get('/', 'AdminProductAttributeController@index')->name('index')->middleware('can:list-product-option');
    Route::get('/create', 'AdminProductAttributeController@create')->name('create')->middleware('can:create-product-option');
    Route::post('/store', 'AdminProductAttributeController@store')->name('store')->middleware('can:store-product-option');
    Route::get('/{id}/edit', 'AdminProductAttributeController@edit')->name('edit')->middleware('can:edit-product-option');
    Route::post('/update/{id}', 'AdminProductAttributeController@update')->name('update')->middleware('can:update-product-option');
    Route::delete('/delete/{id}', 'AdminProductAttributeController@delete')->name('delete')->middleware('can:delete-product-option');

    Route::post('/import', 'AdminProductAttributeController@importFromCsv')->name('import');
});
