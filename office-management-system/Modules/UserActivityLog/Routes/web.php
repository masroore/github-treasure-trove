<?php

use Illuminate\Support\Facades\Route;

Route::prefix('useractivitylog')->group(function (): void {
    Route::get('/', 'UserActivityLogController@index')->name('activity_log');
    Route::get('/user-login', 'UserActivityLogController@login_index')->name('activity_log.login');
});
