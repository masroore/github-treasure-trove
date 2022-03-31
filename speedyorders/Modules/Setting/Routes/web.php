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

Route::group(['prefix' => 'settings', 'middleware' => 'auth:admin'], function () {
    Route::get('/', function () {
        return redirect()->route('settings.general');
    })->name('settings.index');

    Route::get('/general', 'SettingController@index')
        ->name('settings.general')
        ->middleware('can:general-setting');

    Route::get('/ticket', 'SettingController@ticket')
        ->name('settings.ticket')
        ->middleware('can:general-ticket');

    Route::post('/ticket', 'SettingController@updateTicketSetting')
        ->middleware('can:general-ticket');

    Route::post('/general', 'SettingController@updateGeneralSetting')
        ->middleware('can:general-setting');

    Route::get('/sabre', 'SettingController@sabre')
        ->name('settings.sabre')
        ->middleware('can:sabre-config');

    Route::post('/sabre', 'SettingController@updateSabre')
        ->middleware('can:sabre-config');

    Route::get('/plazma', 'SettingController@plazma')
        ->name('settings.plazma')
        ->middleware('can:plazma');

    Route::post('/plazma', 'SettingController@updatePlazmaSetting')
        ->middleware('can:plazma');

    Route::get('/avantik', 'SettingController@avantik')
        ->name('settings.avantik')
        ->middleware('can:avantik');

    Route::post('/avantik', 'SettingController@updateAvantikSetting')
        ->middleware('can:avantik');

    Route::get('api', 'SettingController@api')
        ->name('settings.api')
        ->middleware('can:api-config');

    Route::post('api', 'SettingController@updateApi')
        ->middleware('can:api-config');
});
