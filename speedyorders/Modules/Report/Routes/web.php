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

Route::group(['prefix' => 'reports', 'middleware' => 'auth:admin', 'as' => 'admin.'], function (): void {
    Route::any('/', 'ReportController@index')->name('reports.index');

    Route::any('statements', 'ReportController@statements')->name('reports.statements');
});
