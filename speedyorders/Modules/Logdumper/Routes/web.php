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

Route::group(['prefix' => 'logdumper', 'middleware' => 'auth:admin', 'as' => 'admin.'], function () {
    Route::get('/', 'LogdumperController@index')->name('logdumper');
    Route::post('/', 'LogdumperController@download')->name('log.download');
});

Route::group(['middleware' => 'auth:admin', 'as' => 'admin.', 'prefix' => 'logs'], function () {
    Route::get('/', 'LogdumperController@logs')->name('logs');
});
