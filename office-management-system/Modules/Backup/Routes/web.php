<?php

use Illuminate\Support\Facades\Route;

Route::get('/backup', 'BackupController@index')->name('backup.index');
Route::get('/backup/create', 'BackupController@create')->name('backup.create');
Route::get('/backup/delete/{dir}', 'BackupController@delete')->name('backup.delete');

    Route::post('/import', 'BackupController@import')->name('backup.import');
