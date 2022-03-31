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

Route::group(['prefix' => 'admin/faq/categories', 'middleware' => 'auth:admin', 'as'=>'admin.faq.categories.'], function () {
    Route::get('/', 'AdminFaqCategoryController@index')->name('index')->middleware('can:list-product-option');
    Route::get('/create', 'AdminFaqCategoryController@create')->name('create')->middleware('can:create-product-option');
    Route::post('/store', 'AdminFaqCategoryController@store')->name('store')->middleware('can:store-product-option');
    Route::get('/{id}/edit', 'AdminFaqCategoryController@edit')->name('edit')->middleware('can:edit-product-option');
    Route::post('/update/{id}', 'AdminFaqCategoryController@update')->name('update')->middleware('can:update-product-option');
    Route::delete('/delete/{id}', 'AdminFaqCategoryController@destroy')->name('destroy')->middleware('can:delete-product-option');

    Route::get('/change/status/{id}', 'AdminFaqController@updateFaqCategoryStatus')->name('update.status')->middleware('can:edit-product-option');

    Route::post('/import', 'AdminFaqCategoryController@importFromExcel')->name('import')->middleware('can:delete-product-option');
});

Route::group(['prefix' => 'admin/faq', 'middleware' => 'auth:admin', 'as'=>'admin.faqs.'], function () {
    Route::get('/', 'AdminFaqController@index')->name('index')->middleware('can:list-product-option');
    Route::get('/create', 'AdminFaqController@create')->name('create')->middleware('can:create-product-option');
    Route::post('/store', 'AdminFaqController@store')->name('store')->middleware('can:store-product-option');
    Route::get('/{id}/edit', 'AdminFaqController@edit')->name('edit')->middleware('can:edit-product-option');
    Route::post('/update/{id}', 'AdminFaqController@update')->name('update')->middleware('can:update-product-option');
    Route::delete('/delete/{id}', 'AdminFaqController@destroy')->name('destroy')->middleware('can:delete-product-option');

    Route::get('/change/status/{id}', 'AdminFaqController@updateFaqStatus')->name('update.status')->middleware('can:edit-product-option');

    Route::post('/import', 'AdminFaqController@importFromExcel')->name('import')->middleware('can:delete-product-option');
});
