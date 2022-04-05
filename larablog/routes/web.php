<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');

Auth::routes(['verify' => true]);

Route::group(['prefix' => 'manage', 'middleware' => 'auth'], function (): void {
    // manage users
    Route::resource('users', 'UsersController');

    // change password
    Route::get('user/settings', 'UsersController@showSettings')->name('users.setting');
    Route::post('/users/change/password/{user}', 'UsersController@passChange')->name('users.passChange');

    // manage all categories
    Route::resource('category', 'CategoryController');

    // manage all tags
    Route::resource('tag', 'TagController');

    // manage posts
    Route::resource('post', 'PostController')->except('show');

    // manage roles
    Route::resource('roles', 'RoleController')->except('create');

    // manage permissions
    Route::resource('permissions', 'PermissionController')->except('index', 'create');

    // Change role
    Route::post('change/role/{user}', 'UsersController@changeRole')->name('changeRole');
});

// view post
Route::get('/post/{post:slug}', 'PostController@show')->name('post.show')->where('slug', '[\w\d\-\_]+'); //access post using slug

// Posts by category
Route::get('/categories/{slug:slug}', 'HomeController@postsByCategory');

// Posts by author name
Route::get('/user/{user}/posts', 'HomeController@postsByAuthor');

// Newshelter
Route::post('/newshelter', 'SubscriberController')->name('subscribe');

// Contact Page
Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::post('/contact', 'ContactController@getMessage')->name('contact.post');

// Comments
Route::post('comment.store/{post_id}', 'CommentController@store')->name('comment.store/');
Route::resource('comment', 'CommentController');

// User role
Route::get('/user/role', 'RoleController@index')->name('user.role');

// Search posts
Route::get('searchItem', 'HomeController@searchItem')->name('searchItem');
