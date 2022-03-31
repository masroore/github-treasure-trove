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
Route::group(['prefix' => 'admin/product-question', 'middleware' => 'auth:admin', 'as'=>'admin.product.questions.'], function () {
    Route::get('/', 'AdminProductQuestionController@index')->name('index')->middleware('can:list-product-question');
    Route::get('/create', 'AdminProductQuestionController@create')->name('create')->middleware('can:create-product-question');
    Route::post('/store', 'AdminProductQuestionController@store')->name('store')->middleware('can:store-product-question');
    Route::get('/{id}/edit', 'AdminProductQuestionController@edit')->name('edit')->middleware('can:edit-product-question');
    Route::post('/update/{id}', 'AdminProductQuestionController@update')->name('update')->middleware('can:update-product-question');
    Route::delete('/delete/{id}', 'AdminProductQuestionController@destroy')->name('destroy')->middleware('can:delete-product-question');

    Route::post('/answer/{id}', 'AdminProductQuestionController@answer')->name('answer')->middleware('can:store-product-question-answer');
    Route::delete('/answer/delete/{id}', 'AdminProductQuestionController@destroyAnswer')->name('destroy.answer')->middleware('can:delete-product-question-answer');
});
