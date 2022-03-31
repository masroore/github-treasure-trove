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

Route::group(['prefix' => 'admin/categories', 'middleware' => 'auth:admin', 'as'=>'admin.categories.'], function () {

    // import categories
    Route::get('/import', 'AdminCategoryController@import')->name('import')->middleware('can:create-product');
    Route::post('/import_category_data', 'AdminCategoryController@importData')->name('import_data')->middleware('can:store-product');

    Route::get('/', 'AdminCategoryController@index')->name('index')->middleware('can:list-product-option');
    Route::get('/create', 'AdminCategoryController@create')->name('create')->middleware('can:create-product-option');
    Route::post('/store', 'AdminCategoryController@store')->name('store')->middleware('can:store-product-option');
    Route::get('/{id}/edit', 'AdminCategoryController@edit')->name('edit')->middleware('can:edit-product-option');
    Route::post('/update/{id}', 'AdminCategoryController@update')->name('update')->middleware('can:update-product-option');
    Route::delete('/delete/{id}', 'AdminCategoryController@destroy')->name('destroy')->middleware('can:delete-product-option');

    Route::get('/change/status/{id}', 'AdminCategoryController@updateCategoryStatus')->name('update.status')->middleware('can:edit-product-option');
});
