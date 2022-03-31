<?php

use Modules\AdminApi\Http\Controllers\v1\BannerController;
use Modules\AdminApi\Http\Controllers\v1\CategoryController;
use Modules\AdminApi\Http\Controllers\v1\ChatController;
use Modules\AdminApi\Http\Controllers\v1\CountryController;
use Modules\AdminApi\Http\Controllers\v1\customer\CheckoutController;
use Modules\AdminApi\Http\Controllers\v1\customer\CompareProductController;
use Modules\AdminApi\Http\Controllers\v1\customer\CustomerAuthController;
use Modules\AdminApi\Http\Controllers\v1\customer\WishlistController;
use Modules\AdminApi\Http\Controllers\v1\FilterController;
use Modules\AdminApi\Http\Controllers\v1\GeneralInformationController;
use Modules\AdminApi\Http\Controllers\v1\ProductController;
use Modules\AdminApi\Http\Controllers\v1\StateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'/v1', 'as'=>'api.v1.'], function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/navbar/{isFeatured?}', [CategoryController::class, 'navbarCategories'])->name('navbar.categories');
    Route::get('/categories/parent/homepage/{showOnHomePage?}', [CategoryController::class, 'homePageParentCategories'])->name('homepage.parent.categories');
    Route::get('/categories/child/homepage/{showOnHomePage?}', [CategoryController::class, 'homePageParentChildCategories'])->name('homepage.sub.categories');

    Route::get('/banners', [BannerController::class, 'index'])->name('banners');
    Route::get('/chat-script', [ChatController::class, 'chatScript'])->name('chat.script');

    Route::get('product/{id}', [ProductController::class, 'getProductGeneral'])->name('product.general');
    Route::get('product/{id}/images', [ProductController::class, 'getProductGallery'])->name('product.gallery');
    Route::get('product/{id}/categories', [ProductController::class, 'getProductCategory'])->name('product.category');
    Route::get('product/{id}/optionValues', [ProductController::class, 'getProductOptionValue'])->name('product.optionvalue');
    Route::get('product/{id}/questionsAnswers', [ProductController::class, 'getProductQuestionAnswer'])->name('product.question.answer');
    Route::get('product/{id}/relatedProducts', [ProductController::class, 'getRelatedProducts'])->name('product.related');

    Route::get('/featuredProduct', [ProductController::class, 'featuredProduct'])->name('featured.product');
    Route::get('/topratedProduct', [ProductController::class, 'topRatedProduct'])->name('toprated.product');
    Route::get('/trendingProduct', [ProductController::class, 'trendingProduct'])->name('trending.product');
    Route::get('/generalInformation/{uuid?}', [GeneralInformationController::class, 'generalInformation'])->name('generalinformation');

    Route::get('/countries', [CountryController::class, 'getAllCountry']);
    Route::get('/state/{country_id}', [StateController::class, 'getCountryState']);

    Route::get('/products', [FilterController::class, 'allProducts']);
    Route::get('/filter-categories', [FilterController::class, 'Categories']);

    //  authenticated customer routes

    Route::group(['middleware'=>['auth:sanctum']], function () {

    // customer info
        Route::get('/user', [CustomerAuthController::class, 'user'])->name('user');

        // compare routes
        Route::post('/add-to-customer-comparelist', [CompareProductController::class, 'addToCompareList'])->name('addToCustomerCompareList');
        Route::get('/customer-comparelist', [CompareProductController::class, 'getCustomerComparelist'])->name('getCustomerCompareList');

        // wishlist routes
        Route::get('/customer-wishlist', 'v1\customer\WishlistController@getCustomerWishlist')->name('getCustomerWishlist');
        Route::post('/add-to-wishlist', [WishlistController::class, 'addToWishlist'])->name('addToWishlist');

        Route::post('/customer-checkout', [CheckoutController::class, 'customerCheckout'])->name('customerCheckout');

        Route::post('/logout', 'v1\customer\CustomerAuthController@logout')->name('logout');
    });

    //  customer auth
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('customerLogin');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('registerCustomer');
    Route::post('/reset/password', [CustomerAuthController::class, 'resetPassword'])->name('resetPassword');
    Route::post('/update/password', [CustomerAuthController::class, 'updatePassword'])->name('updatePassword');
    Route::get('password/reset/{token}/{email}', [CustomerAuthController::class, 'resetPasswordMail'])->name('resetPasswordFromMail');

    // checkout
    Route::post('/guest-checkout', [CheckoutController::class, 'guestCheckout'])->name('checkout');
});
