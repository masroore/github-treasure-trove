<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\DiscountVoucherController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// routes without auth
Route::post('/noti', function () {
    $notifiable_type = 'App\Models\Orders';
    $notifiable_id = 1;
    $sender_id = 3;
    $body = 'this is test notification';
    $title = 'this is test title';
    $type = 'Oders';
    $redirect = null;
    sendnote($notifiable_type, $notifiable_id, $sender_id, $body, $title, $type, $redirect);
});
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/verify', [UserController::class, 'verify']);
Route::get('/verify_link', [UserController::class, 'verifyWithLink']);
Route::post('/resend_activation', [UserController::class, 'resendActivation']);
Route::post('/forgot_password', [UserController::class, 'forgot']);
Route::post('/reset_password', [UserController::class, 'reset']);
Route::post('/reset_link', [UserController::class, 'resetWithLink']);
Route::post('/resend_code', [UserController::class, 'resendActivationCode']);
Route::delete('/delete/{email}', [UserController::class, 'destroy']);
// routes with auth
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/change_password', [UserController::class, 'changePassword']);
    Route::get('/deactivate', [UserController::class, 'deactivate']);

    Route::get('/logout', [UserController::class, 'logout']);
    // Update Profile
    Route::put('/profile', [UserController::class, 'profileUpdate']);
    // Update Profile Image
    Route::post('/imageUpdate', [UserController::class, 'imageUpdate']);

    Route::put('/{store}/default', [UserController::class, 'default']);

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', [UserController::class, 'notificationview']);
        Route::delete('/{id}', [StoreController::class, 'deletenoti']);
        Route::post('/{id}', [StoreController::class, 'statuChange']);
    });
    // make default address
    Route::post('/address/{address}/default', [
        AddressController::class, 'default',
    ]);

    // address routes
    Route::resource('address', AddressController::class);

    Route::group(['prefix' => 'comment'], function () {
        Route::post('/store', ['uses'=>'App\Http\Controllers\CommentController@storeComments']);
        Route::post('/product', ['uses'=>'App\Http\Controllers\CommentController@productComments']);
        Route::get('/store/{id}', ['uses'=>'App\Http\Controllers\CommentController@showStoreComments']);
        Route::post('/like', ['uses'=>'App\Http\Controllers\CommentController@like']);
        Route::post('/{id}', ['uses'=>'App\Http\Controllers\CommentController@update']);
        Route::delete('/{id}', ['uses'=>'App\Http\Controllers\CommentController@destroy']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/get-payment-methods/', ['uses' => 'App\Http\Controllers\CardSessionController@index']);
        Route::put('/manage-payment-method-default-status/{id}', ['uses' => 'App\Http\Controllers\CardSessionController@update']);
        Route::delete('/delete-payment-method/{id}', ['uses' => 'App\Http\Controllers\CardSessionController@destroy']);
        Route::post('/place-order', ['uses'=>'App\Http\Controllers\OrderController@store']);
        Route::post('/update-status', ['uses'=>'App\Http\Controllers\OrderController@statusUpdate']);
        Route::get('/', ['uses'=>'App\Http\Controllers\OrderController@view']);
        Route::get('/{id}', ['uses'=>'App\Http\Controllers\OrderController@show']);
        Route::put('/{id}', ['uses'=>'App\Http\Controllers\OrderController@update']);
        Route::delete('/{id}', ['uses'=>'App\Http\Controllers\OrderController@destroy']);
    });
    // favorites
    Route::group(['prefix' => 'favorite'], function () {
        Route::group(['prefix' => 'store'], function () {
            Route::put('/{store}', [FavoritesController::class, 'addFavoriteStore']);
            Route::delete('/{store}', [FavoritesController::class, 'deleteFavoriteStore']);
            Route::get('/', [FavoritesController::class, 'getFavoriteStores']);
        });

        Route::group(['prefix' => 'product'], function () {
            Route::put('/{product}', [FavoritesController::class, 'addFavoriteProduct']);
            Route::delete('/{product}', [FavoritesController::class, 'deleteFavoriteProduct']);
            Route::get('/', [FavoritesController::class, 'getFavoriteProducts']);
        });
    });

    Route::group(['prefix' => 'voucher'], function () {
        Route::post('/{voucher}', [DiscountVoucherController::class, 'checkVoucher']);
    });
});
