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

Route::group(['prefix' => '/admin/dashboard', 'middleware' => 'auth:admin'], function (): void {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');

    // TODAY'S SUMMARY
    Route::any('today-summary', [
        'as' => 'today-summary',
        'uses' => 'DashboardController@todaysSummary',
    ]);

    // DB QUREY
    Route::any('db-statement', [
        'as' => 'db-statement',
        'uses' => 'DashboardController@dbStatement',
    ]);

    // LOG DUMPER
    Route::any('log-dumper', [
        'as' => 'log-dumper',
        'uses' => 'DashboardController@logDumper',
    ]);

    // MASTER SETTINGS
    Route::any('master-config', [
        'as' => 'master-config',
        'uses' => 'DashboardController@masterConfig',
    ]);

    // LICENSE
    Route::any('license', [
        'as' => 'license',
        'uses' => 'DashboardController@license',
    ]);

    // Refresh Redis Cache
    Route::get('/refresh-redis', function (): void {
        dump('refreshing redis');

        $refreshRedis = \Artisan::call('redis:cache');

        dump(\Artisan::output());
        dd('refreshing redis complete');
    });
});
