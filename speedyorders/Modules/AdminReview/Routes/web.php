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

Route::group(['prefix' => 'admin/reviews', 'middleware' => 'auth:admin', 'as' => 'admin.reviews.'], function (): void {
    Route::get('/', 'AdminReviewController@index')->name('index')->middleware('can:list-product-review');
    Route::get('/create', 'AdminReviewController@create')->name('create')->middleware('can:create-product-review');
    Route::post('/store', 'AdminReviewController@store')->name('store')->middleware('can:store-product-review');
    Route::get('/{id}/edit', 'AdminReviewController@edit')->name('edit')->middleware('can:edit-product-review');
    Route::post('/update/{id}', 'AdminReviewController@update')->name('update')->middleware('can:update-product-review');
    Route::delete('/delete/{id}', 'AdminReviewController@destroy')->name('destroy')->middleware('can:delete-product-review');

    Route::get('/change/status/{id}', 'AdminReviewController@updateReviewStatus')->name('update.status')->middleware('can:edit-product-option');
});
