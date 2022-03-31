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

Route::group(['prefix' => 'admin/products', 'middleware' => 'auth:admin', 'as'=>'admin.products.'], function () {

    // import products
    Route::get('/import', 'AdminProductController@import')->name('import')->middleware('can:create-product');
    Route::post('/import_products_data', 'AdminProductController@importData')->name('import_data')->middleware('can:store-product');

    Route::get('/', 'AdminProductController@index')->name('index')->middleware('can:list-product');
    Route::get('/create', 'AdminProductController@create')->name('create')->middleware('can:create-product');
    Route::post('/store', 'AdminProductController@store')->name('store')->middleware('can:store-product');
    Route::get('/{id}/edit', 'AdminProductController@edit')->name('edit')->middleware('can:edit-product');
    Route::post('/update/{id}', 'AdminProductController@update')->name('update')->middleware('can:update-product');
    Route::delete('/delete/{id}', 'AdminProductController@destroy')->name('delete')->middleware('can:delete-product');
    Route::post('/upload-product-media', 'AdminProductController@uploadProductMedia')->name('upload.media')->middleware('can:edit-product');
    Route::get('/get-product-media/{ids}', 'AdminProductController@getProductMedia')->name('get.media')->middleware('can:edit-product');
    Route::get('/get-single-product-media/{id}', 'AdminProductController@getSingleProductMedia')->name('get.single.media')->middleware('can:edit-product');
    Route::post('/update-single-product-media', 'AdminProductController@updateSingleProductMedia')->name('update.single.media')->middleware('can:edit-product');
    Route::get('/delete-product-media/{id}', 'AdminProductController@deleteProductMedia')->name('delete.media')->middleware('can:edit-product');

    Route::get('/change/status/{id}', 'AdminProductController@updateProductStatus')->name('update.status')->middleware('can:edit-product-option');

    Route::post('/option', 'AdminProductAjaxController@option')->name('ajax.option')->middleware('can:edit-product');
    Route::post('/group', 'AdminProductAjaxController@group')->name('ajax.group')->middleware('can:edit-product');

    Route::post('/option/value', 'AdminProductAjaxController@optionValue')->name('ajax.option.value')->middleware('can:edit-product');

    Route::get('/get-group-details/{group_id}', 'AdminProductController@getProductGroupData')->name('get.group')->middleware('can:store-product');

    Route::post('/package/deliverytime', 'AdminProductAjaxController@packageDeliveryTime')->name('ajax.package.deliverytime')->middleware('can:edit-product');
});
