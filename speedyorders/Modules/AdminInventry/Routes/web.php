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

Route::group(['prefix' => 'admin/inventry', 'middleware' => 'auth:admin', 'as' => 'admin.inventry.'], function (): void {
    Route::get('/list', 'AdminInventryController@index')->name('index')->middleware('can:list-inventry');

    Route::post('/addSetProductAvailibility', 'AdminInventryController@addSetAvailability')->name('add.set')->middleware('can:edit-inventry');
});
