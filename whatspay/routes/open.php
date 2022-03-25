<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'store'], function () {
    Route::get('/{url}', [PublicController::class, 'getStore']);
    Route::get('/{store}/categories', [PublicController::class, 'storeCategories']);
    Route::get('/{store}/{category}/products', [PublicController::class, 'categoryProducts']);
    Route::get('/{url}/branch', [PublicController::class, 'getBranch']);
});

Route::get('/industries/{slug}', [PublicController::class, 'storesByIndustry']);
Route::get('/stores', [PublicController::class, 'homeListing']);
//Route::get('/store/slug/{slug}', [PublicController::class, 'showStore']);
Route::get('/stores/search/{keyword}', [PublicController::class, 'search']);
