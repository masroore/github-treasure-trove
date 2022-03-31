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

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/users', 'AdminController@index')
        ->name('users')
        ->middleware('can:view-users');

    Route::get('/users/create', 'AdminController@create')
        ->name('users.create')
        ->middleware('can:create-users');

    Route::post('/users/store', 'AdminController@store')
        ->name('users.store')
        ->middleware('can:create-users');

    Route::get('/users/{id}/edit', 'AdminController@edit')
        ->name('users.edit')
        ->middleware('can:edit-users');

    Route::put('/users/{id}/update', 'AdminController@update')
        ->name('users.update')
        ->middleware('can:edit-users');

    Route::delete('/users/{id}/delete', 'AdminController@delete')
        ->name('users.delete')
        ->middleware('can:delete-users');

    Route::get('/groups', 'GroupController@index')
        ->name('groups')
        ->middleware('can:view-groups');

    Route::get('/groups/create', 'GroupController@create')
        ->name('groups.create')
        ->middleware('can:create-groups');

    Route::post('/groups/store', 'GroupController@store')
        ->name('groups.store')
        ->middleware('can:create-groups');

    Route::get('/groups/{id}/edit', 'GroupController@edit')
        ->name('groups.edit')
        ->middleware('can:edit-groups');

    Route::put('/groups/{id}/update', 'GroupController@update')
        ->name('groups.update')
        ->middleware('can:edit-groups');

    Route::delete('/groups/{id}/delete', 'GroupController@delete')
        ->name('groups.delete')
        ->middleware('can:delete-groups');

    Route::get('/groups/{id}/edit-permission', 'GroupController@editPermission')
        ->name('groups.edit-permission');

    Route::post('/groups/{id}/edit-permission', 'GroupController@storePermission');

    Route::get('/users/{id}/change-status', 'AdminController@changeStatus')
        ->name('users.status')
        ->middleware('can:edit-users');

    Route::post('/users/{id}/change-password', 'AdminController@updatePassword')
        ->name('users.reset-password')
        ->middleware('can:edit-users');

    Route::get('profile', 'AdminController@profile')->name('users.profile');
    Route::post('profile', 'AdminController@updateProfile');

    Route::get('/reset-password', 'AdminController@resetPassword')
        ->name('users.reset-password');

    Route::post('/reset-password', 'AdminController@changePassword');
});
