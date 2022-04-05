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

Route::group(['prefix' => 'admin/page', 'middleware' => 'auth:admin', 'as' => 'admin.pages.'], function (): void {
    Route::get('/', 'AdminPageController@index')->name('index')->middleware('can:list-product-option');
    Route::get('/create', 'AdminPageController@create')->name('create')->middleware('can:create-product-option');
    Route::post('/store', 'AdminPageController@store')->name('store')->middleware('can:store-product-option');
    Route::get('/{id}/edit', 'AdminPageController@edit')->name('edit')->middleware('can:edit-product-option');
    Route::post('/update/{id}', 'AdminPageController@update')->name('update')->middleware('can:update-product-option');
    Route::delete('/delete/{id}', 'AdminPageController@destroy')->name('destroy')->middleware('can:delete-product-option');

    Route::get('/banner', 'AdminBannerController@index')->name('banners.index')->middleware('can:list-product-option');
    Route::get('/banner/create', 'AdminBannerController@create')->name('banners.create')->middleware('can:edit-pages-banner');
    Route::post('/banner/store', 'AdminBannerController@store')->name('banners.store')->middleware('can:edit-pages-banner');
    Route::get('/banner/{id}/edit', 'AdminBannerController@edit')->name('banners.edit')->middleware('can:edit-pages-banner');
    Route::post('/banner/update', 'AdminBannerController@update')->name('banners.update')->middleware('can:edit-pages-banner');
    Route::delete('banner/delete/{id}', 'AdminBannerController@destroy')->name('banners.destroy')->middleware('can:delete-product-option');
    Route::get('/change/banner/status/{id}', 'AdminBannerController@updateBannerStatus')->name('update.banner.status')->middleware('can:edit-product-option');

    Route::get('/component', 'AdminPageComponentController@index')->name('components.index')->middleware('can:list-product-option');
    Route::get('/component/create', 'AdminPageComponentController@create')->name('components.create')->middleware('can:edit-pages-banner');
    Route::post('/component/store', 'AdminPageComponentController@store')->name('components.store')->middleware('can:edit-pages-banner');
    Route::get('/component/{id}/edit', 'AdminPageComponentController@edit')->name('components.edit')->middleware('can:edit-pages-banner');
    Route::post('/component/update', 'AdminPageComponentController@update')->name('components.update')->middleware('can:edit-pages-banner');
    Route::delete('/component/delete/{id}', 'AdminPageComponentController@destroy')->name('components.destroy')->middleware('can:delete-product-option');
    Route::get('/change/pagecomponent/status/{id}', 'AdminPageComponentController@updatePageComponentStatus')->name('update.pagecomponents.status')->middleware('can:edit-product-option');
});
