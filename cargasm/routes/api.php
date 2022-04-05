<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'middleware' => 'api'], function (): void {

//    Broadcast::routes(['middleware' => 'auth:api']);

    //Статус заказа
    Route::post('/order/status', 'OrderController@status');

    //DOMAIN
//    Route::get('domains', 'DomainController@index');

    Route::group([
        'prefix' => 'control',
        'namespace' => 'Control',
        'middleware' => 'auth:sanctum',
    ], function (): void {
        // PROFILE
        Route::get('profile/me', 'ProfileController@me');
        Route::get('profile', 'ProfileController@edit');
        Route::post('profile', 'ProfileController@save');
    });

//    Route::group(['middleware' => ['check.domain', 'set.language']], function () {
    Route::group([], function (): void {

        // REGISTER AND LOGIN
        Route::group(['namespace' => 'Auth'], function (): void {
            Route::group(['prefix' => 'auth'], function (): void {
                Route::post('login', 'LoginController@login');
                Route::post('logout', 'LoginController@logout');
                Route::post('refresh', 'LoginController@refresh');
                Route::post('register', 'RegisterController@register');

                // SOCIALITE
                Route::get('{provider}', 'SocialiteLoginController@redirectToProvider')->name('socialite.oauth');
                Route::any('{provider}/callback', 'SocialiteLoginController@handleProviderCallback');
            });

            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
            Route::post('password/reset', 'ResetPasswordController@reset');
            Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
        });

        // CONTROL
        Route::group([
            'prefix' => 'control',
            'namespace' => 'Control',
            'middleware' => 'auth:sanctum',
        ], function (): void {

            //PAGES
            Route::resource('pages', 'PageController', ['except' => ['show', 'destroy']]);
            Route::post('pages/sync', 'PageController@sync');
            Route::get('pages/{pageId}/seo', 'PageController@seoEdit');
            Route::post('pages/{pageId}/seo', 'PageController@seoSave');

            //MENU
            Route::get('menus', 'MenuController@index');

            //MENU_ITEMS
            Route::get('menus/{menuId}/items', 'MenuItemController@index');
            Route::get('menus/{menuId}/items/create', 'MenuItemController@create');
            Route::post('menus/{menuId}/items', 'MenuItemController@store');
            Route::get('menus/items/{menuItemId}/edit', 'MenuItemController@edit');
            Route::patch('menus/items/{menuItemId}', 'MenuItemController@update');
            Route::post('menus/items/sync', 'MenuItemController@sync');
            Route::post('menus/items/order', 'MenuItemController@order');

            // BANNERS
            Route::resource('banners', 'BannerController', ['except' => ['show', 'destroy']]);
            Route::post('banners/sync', 'BannerController@sync');

            //Справочник
            Route::post('handbook/sync', 'HandbookController@sync');
            Route::get('handbook', 'HandbookController@index');
            Route::get('handbook/{handbookId}', 'HandbookController@show');
            Route::post('handbook/{id}', 'HandbookController@store');
            Route::delete('handbook/{id}', 'HandbookController@destroy');

            // TERMS
            Route::group(['prefix' => 'terms'], function (): void {
                Route::get('brands', 'CarBrandController@index');
                Route::post('brands', 'CarBrandController@store');
                Route::get('brands/{brandId}/edit', 'CarBrandController@edit');
                Route::patch('brands/{brandId}', 'CarBrandController@update');
                Route::delete('brands/{brandId}', 'CarBrandController@destroy');

                Route::post('brands/sync', 'CarBrandController@sync');

                Route::get('brands/{brandId}/seo', 'CarBrandController@seoEdit');
                Route::post('brands/{brandId}/seo', 'CarBrandController@seoSave');

                Route::get('models/create', 'CarModelController@create');
                Route::post('models', 'CarModelController@store');
                Route::get('models/{modelId}/edit', 'CarModelController@edit');
                Route::patch('models/{modelId}', 'CarModelController@update');
                Route::delete('models/{modelId}', 'CarModelController@destroy');

                Route::get('models/{modelId}/media', 'CarModelController@mediaEdit');
                Route::post('models/{modelId}/media', 'CarModelController@mediaSave');
            });

            // USERS
            Route::resource('users', 'UserController', ['except' => 'show']);
            Route::post('users/sync', 'UserController@sync');

            //Errors and complaints
            Route::get('complaints', 'ComplaintController@index');
            Route::get('complaints/{id}', 'ComplaintController@show');
            Route::delete('complaints/{id}', 'ComplaintController@destroy');

            // SERVICES
            Route::resource('services', 'ServiceController', ['except' => 'show']);
            Route::get('services/{serviceId}/media', 'ServiceController@mediaEdit');
            Route::post('services/{serviceId}/media', 'ServiceController@mediaSave');
            Route::get('services/{serviceId}/seo', 'ServiceController@seoEdit');
            Route::post('services/{serviceId}/seo', 'ServiceController@seoSave');
            Route::post('services/sync', 'ServiceController@sync');

            //POSTS
            Route::resource('posts', 'PostController', ['except' => ['show']]);
            Route::post('posts/sync', 'PostController@sync');
            Route::get('posts/{postId}/seo', 'PostController@seoEdit');
            Route::post('posts/{postId}/seo', 'PostController@seoSave');
            Route::get('posts/{postId}/comments', 'PostController@getPostComments');

            //NEWS
            Route::get('news', 'PostController@getNews');

            //Events
            Route::resource('events', 'EventController', ['except' => ['show']]);
//            Route::post('events/slider', 'EventController@toSlider');
            Route::post('events/slider', 'EventController@toSlider');
            Route::post('events/slider', 'EventController@toSlider');
            Route::get('events/{eventId}/media', 'EventController@mediaEdit');
            Route::post('events/{eventId}/media', 'EventController@mediaSave');
            Route::get('events/{eventId}/seo', 'EventController@seoEdit');
            Route::post('events/{eventId}/seo', 'EventController@seoSave');
            Route::get('events/{id}/comments', 'EventController@getEventComments');
            Route::post('events/sync', 'EventController@sync');

            // TODO: POST COMMENTS
//            Route::get('posts/{postId}/comments', 'PostController@getPostComments');
//            Route::post('posts/{postId}/comments', 'PostCommentController@store');
//            Route::get('posts/{postId}/comments/{commentsId}/edit', 'PostCommentController@edit');
//            Route::patch('posts/comments/{commentsId}', 'PostCommentController@update');
//            Route::delete('posts/comments/{commentsId}', 'PostCommentController@destroy');
//            Route::post('posts/comments/sync', 'PostCommentController@sync');

            // CARS
            Route::resource('cars', 'CarController', ['except' => 'show']);
            Route::get('cars/{carId}/media', 'CarController@mediaEdit');
            Route::post('cars/{carId}/media', 'CarController@mediaSave');
            Route::get('cars/{carId}/seo', 'CarController@seoEdit');
            Route::post('cars/{carId}/seo', 'CarController@seoSave');

            // VARIABLES
            Route::get('variables/list', 'VariableController@list');
            Route::get('variables/{key}', 'VariableController@show');
            Route::post('variables', 'VariableController@save');
            // SEO-MASKS
            Route::get('variables/seo-masks/form', 'VariableController@editSeoMasks');
            Route::post('variables/seo-masks/form', 'VariableController@saveSeoMasks');

            //COMMENTS
//            Route::post('comments/{id}', 'CommentController@store');
//            Route::put('comments/{id}', 'CommentController@update');
            Route::delete('comments/{id}', 'CommentController@destroy');
            Route::post('comments/sync', 'CommentController@sync');

            Route::delete('medias/{id}', 'MediaController@destroy');
        });

        //CARS
        Route::group(['prefix' => 'cars'], function (): void {
            //Поиск для марки автомобиля
            Route::get('brands', 'CarController@brands');
            Route::get('models', 'CarController@models');
            Route::get('catalog/brands', 'CarController@brandsMagazine');
            Route::post('catalog/model', 'CarController@modelMagazine');

            Route::get('{car}/edit', 'CarController@edit');

            Route::post('store/self-car', 'CarController@storeSelf');
        });

        //FEEDBACK
        Route::get('feedbacks/problems', 'FeedbackController@getProblems');
        Route::post('feedbacks', 'FeedbackController@store');

        //Notifications
        Route::apiResource('notifies', 'NotifyController', ['only' => ['index']]);
        Route::post('notifies/delete', 'NotifyController@deleteAll');

        //POST
        Route::apiResource('posts', 'PostController');
        Route::get('posts/{id}/comments', 'PostController@getPostComments');
        Route::post('posts/{id}/comment', 'PostController@comment');
        Route::post('posts/{id}/like', 'PostController@getLike');
        Route::post('posts/{id}/share', 'PostController@share');
        Route::post('posts/{id}/complaint', 'PostController@complaint');
        Route::post('posts/{id}/favorite', 'PostController@favorite');
        Route::post('posts/translate', 'PostController@addTransition');
        Route::post('posts/{id}/change', 'PostController@changeStatus');

        //NEWS
        Route::get('news', 'PostController@getNews');

        Route::get('users/{id}/posts', 'PostController@getUserPosts');
        Route::get('users/{id}/cars', 'CarController@getUserCars');

        // PHOTOS
        Route::group(['prefix' => 'gallery'], function (): void {
            // Route::resource('photos', 'PhotoController')->except(['store']);
            Route::resource('photos', 'PhotoController')->except('create');
            Route::post('photos/{id}/like', 'PhotoController@getLike');
            Route::post('photos/{id}/comment', 'PhotoController@comment');
            Route::get('photos/{id}/comments', 'PhotoController@getPhotoComments');
            Route::post('photos/{id}/share', 'PhotoController@share');
            Route::resource('albums', 'AlbumController');
        });

        Route::get('users/{id}/photos', 'PhotoController@getUserPhotos');
        Route::get('users/{id}/albums', 'AlbumController@getUserAlbums');

        //EVENTS
//        Route::post('events/{id}/invite', 'EventController@invite');
        Route::post('events/{id}/deleteUser', 'EventController@deleteUser');

        Route::post('events/{id}/photos', 'EventController@addPhotos');
        Route::get('events/{id}/comments', 'EventController@getEventComments');
        Route::post('events/{id}/comment', 'EventController@comment');
        Route::post('events/{id}/favorite', 'EventController@favorite');
        Route::post('events/{id}/share', 'EventController@share');
        Route::post('events/{id}/complaint', 'EventController@complaint');
        Route::post('events/{id}/like', 'EventController@getLike');

        Route::post('events/{id}/statuses', 'EventController@changeStatus');
        Route::get('users/{id}/events', 'EventController@getUserEvents');

        Route::post('events/{id}/attend', 'EventController@attend');
        Route::get('events/{id}/users-all', 'EventController@allUsers');
        Route::get('events/slider', 'EventController@slider');
        Route::get('events/all', 'EventController@allEvents');
        Route::get('users/{id}/onward', 'EventController@onward');
        Route::resource('events', 'EventController');

        //SERVICES
        Route::get('services/search', 'ServiceController@searchService');
        Route::apiResource('services', 'ServiceController');
        Route::get('services/{id}/posts', 'ServiceController@getServicesPosts');
        Route::get('services/{id}/ratings ', 'ServiceController@getServicesRatings');
        Route::get('users/{id}/services', 'ServiceController@getUserServices');
        Route::post('services/{id}/complaint', 'ServiceController@complaint');

        //USER
        Route::post('users/{id}/ban', 'UserController@ban');
        Route::post('users/{id}/unban', 'UserController@unban');
        Route::get('users/banned', 'UserController@getBannedUsers');
        Route::get('users/{id}', 'UserController@show');
        Route::get('user', 'UserController@index');
        Route::post('user', 'UserController@store');
        Route::get('user/authors', 'UserController@getAuthors');
        Route::get('user/entity/quantity', 'UserController@getCountEntity');
        Route::post('user/setting', 'UserController@setting');
        Route::post('user/password', 'UserController@password');
        Route::post('users', 'UserController@getAllUsers');
        Route::post('users/{id}/complaint', 'UserController@complaint');

        Route::post('users/push', 'UserController@push');
        Route::get('pusher', 'UserController@pusher');
        //CARS
        Route::post('cars/{id}/complaint', 'CarController@complaint');

        //SUBSCRIBE
        Route::post('subscribe', 'SubscriptionController@subscribe');
        Route::post('unsubscribe', 'SubscriptionController@unsubscribe');
        Route::get('users/{id}/subscriptions', 'SubscriptionController@getSubscriptions');
        Route::get('users/{id}/subscribers', 'SubscriptionController@getSubscribers');

        //AUTOCOMPLETE
        Route::group(['prefix' => 'autocomplete'], function (): void {
            Route::get('brands', 'AutocompleteController@carBrands');
            Route::get('geo', 'AutocompleteController@geo');
            Route::get('models', 'AutocompleteController@carModels');
            Route::get('users', 'AutocompleteController@users')
                ->middleware('auth:api');
            Route::get('services', 'AutocompleteController@services')
                ->middleware('auth:api');
        });

        //chat
        Route::get('messages/unread', 'ChatController@unreadCount');
        Route::post('messages', 'ChatController@sendMessage');
        Route::match(['put', 'patch'], 'messages/{id}', 'ChatController@updateMessage');
        Route::delete('messages/{id}', 'ChatController@deleteMessage');
        Route::get('conversations', 'ChatController@getAllConversations');
        Route::get('conversations/{id}/info', 'ChatController@getInfoConversation');
        Route::get('conversations/{conv_id}/messages', 'ChatController@getAllMessagesForConversation');
        Route::post('conversations/{conv_id}/reads', 'ChatController@messageMarksRead');
        Route::delete('conversations/{conv_id}', 'ChatController@deleteConversations');

        //Home page - "Моя страница"
        Route::get('main/{id}', 'MainController@index');

        Route::group(['middleware' => 'auth:sanctum'], function (): void {
            //LIKE
//            Route::post('like', 'LikeController@like');
            //COMMENTS
            Route::post('comments/{commentId}/like', 'CommentController@getLike');
            Route::post('comments/{id}', 'CommentController@store');
            Route::post('comments/{id}/complaint', 'CommentController@complaint');
            Route::put('comments/{id}', 'CommentController@update');
            Route::delete('comments/{id}', 'CommentController@destroy');

            //RATINGS SERVICE
            Route::post('ratings', 'RatingController@store');
            Route::post('ratings/{id}', 'RatingController@update');
            Route::delete('ratings/{id}', 'RatingController@destroy');
            Route::post('ratings/{id}/comment', 'RatingController@comment');
            Route::post('ratings/{id}/like', 'RatingController@getLike');
            Route::post('ratings/{id}/complaint', 'RatingController@complaint');

//            Route::get('users/{id}/favorites', 'FeedController@getFavorites');
            Route::group(['prefix' => 'user'], function (): void {
                //FEED
                Route::get('favorites', 'FeedController@getFavorites');
                Route::get('all-feed', 'FeedController@allFeed');
                Route::get('news-feed', 'FeedController@getNewsFeed');
                Route::get('events-feed', 'FeedController@getEventsFeed');
                Route::get('recommends', 'FeedController@getRecommendedPosts');
            });

            Route::apiResource('cars', 'CarController');

            //MEDIA
            Route::post('medias', 'MediaController@store');
            Route::delete('medias/{id}', 'MediaController@destroy');
        });
        //MENU
        Route::get('menus/list', 'MenuController@list');
        //PAGE
        Route::get('page/{slug}', 'PageController@show');
        //BANNER
        Route::get('banners/list', 'BannerController@list');

        Route::get('seo/{type}', 'SeoController@show');
    });

    // VERIFY EMAIL
    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
});
