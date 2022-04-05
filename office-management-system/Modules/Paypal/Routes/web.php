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

use Illuminate\Support\Facades\Route;

Route::prefix('paypal')->group(function (): void {
    Route::post('/process', 'PaypalController@process')->name('paypal.process');
    Route::get('/execute', 'PaypalController@execute')->name('paypal.execute');
    Route::get('/cancel', 'PaypalController@cancel');
});
