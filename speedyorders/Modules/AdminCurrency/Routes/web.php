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

Route::group(['middleware' => 'auth:admin', 'as' => 'admin.'], function () {
    Route::get('/currencies', 'AdminCurrencyController@index')
        ->name('currencies.index')
        ->middleware('can:view-currency');

    Route::post('/currencies', 'AdminCurrencyController@fetchCurrencyRates')
        ->name('currencies.fetch')
        ->middleware('can:edit-currency');
});
