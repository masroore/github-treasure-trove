<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\Fontawsomeicons;
use App\Http\Controllers\Industries;
use App\Http\Controllers\Places;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagsController;
use Illuminate\Support\Facades\Route;

// routes
//home page
Route::get('/industries', [Industries::class, 'index']);
Route::get('/industries/{slug}', [Industries::class, 'show']);
Route::get('/stores/search', [ProductController::class, 'filterStores']);

// countries and cities
Route::get('/places', [Places::class, 'countries']);
Route::get('/places/{place}', [Places::class, 'country']);

Route::get('/product/{id}', ['uses'=>'App\Http\Controllers\CommentController@showProductComments']);

//Get fount awesome icons
Route::get('/icons', [Fontawsomeicons::class, 'icons']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // brand routes
    Route::resource('brands', BrandsController::class);

    // Tags routes
    Route::group(['prefix' => 'tags'], function () {
        // search
        Route::get('/search/{keyword}', [TagsController::class, 'search']);

        Route::get('/', [TagsController::class, 'index']);
        Route::post('/', [TagsController::class, 'store']);
//        Route::get('/{tag}', [TagsController::class, 'show']);
//        Route::delete('/{tag}', [TagsController::class, 'destroy']);
        Route::put('/{tag}', [TagsController::class, 'update']);
    });
});
