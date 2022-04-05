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

Route::group(['prefix' => '/admin/settings', 'middleware' => 'auth:admin'], function (): void {
    Route::get('/general', 'AdminSettingController@index')
        ->name('admin.settings')
        ->middleware('can:general-setting');

    Route::post('/general', 'AdminSettingController@updateGeneralSetting')
        ->name('admin.settings')
        ->middleware('can:general-setting');

    Route::get('/paypal', 'AdminSettingController@paypalIndex')
        ->name('admin.settings.paypal')
        ->middleware('can:general-setting');

    Route::post('/paypal', 'AdminSettingController@updatePaypalSetting')
        ->name('admin.settings.update.paypal')
        ->middleware('can:general-setting');

    Route::get('/stripe', 'AdminSettingController@stripeIndex')
        ->name('admin.settings.stripe')
        ->middleware('can:general-setting');

    Route::post('/stripe', 'AdminSettingController@updateStripeSetting')
        ->name('admin.settings.update.stripe')
        ->middleware('can:general-setting');

    Route::get('/shipping', 'AdminSettingController@shippingIndex')
        ->name('admin.settings.shipping')
        ->middleware('can:general-setting');

    Route::post('/shipping', 'AdminSettingController@updateShippingSetting')
        ->name('admin.settings.update.shipping')
        ->middleware('can:general-setting');

    Route::get('/chat', 'AdminSettingController@chatIndex')
        ->name('admin.settings.chat')
        ->middleware('can:general-setting');

    Route::post('/chat', 'AdminSettingController@updateChatSetting')
        ->name('admin.settings.update.chat')
        ->middleware('can:general-setting');

    Route::get('/google/analytics', 'AdminSettingController@googleAnalyticsIndex')
        ->name('admin.settings.googleanalytics')
        ->middleware('can:general-setting');

    Route::post('/google/analytics', 'AdminSettingController@updateGoogleAnalyticsSetting')
        ->name('admin.settings.update.googleanalytics')
        ->middleware('can:general-setting');

    Route::get('/social/media', 'AdminSettingController@socialMediaIndex')
        ->name('admin.settings.socialmedia')
        ->middleware('can:general-setting');

    Route::post('/social/media', 'AdminSettingController@updateSocialMediaSetting')
        ->name('admin.settings.update.socialmedia')
        ->middleware('can:general-setting');

    Route::get('/cod', 'AdminSettingController@codIndex')
        ->name('admin.settings.cod')
        ->middleware('can:general-setting');

    Route::post('/cod', 'AdminSettingController@updateCODSetting')
        ->name('admin.settings.update.cod')
        ->middleware('can:general-setting');
});
