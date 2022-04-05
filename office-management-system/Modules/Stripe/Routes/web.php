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

Route::prefix('stripe')->name('stripe.')->group(function (): void {
    Route::get('/card', 'StripeController@index')->name('index');
    Route::post('/process', 'StripeController@process')->name('process');

    Route::get('/ret', 'StripeController@retrive');
});
