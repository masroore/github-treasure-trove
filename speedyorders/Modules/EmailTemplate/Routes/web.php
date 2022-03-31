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

Route::group(['prefix' => 'email-templates', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::get('/', 'EmailTemplateController@index')->name('email-templates');
    Route::get('/{id}/edit', 'EmailTemplateController@edit')->name('email.edit');
});
