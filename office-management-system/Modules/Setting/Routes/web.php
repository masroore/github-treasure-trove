<?php

use Illuminate\Support\Facades\Route;

Route::prefix('setting')->middleware('auth')->group(function (): void {
    Route::get('/', 'SettingController@index')->name('setting.index');
    Route::post('/update-activation-status', 'SettingController@update_activation_status')->name('update_activation_status');

    Route::post('general-settings/update', 'GeneralSettingsController@update')->name('company_information_update');

    Route::post('invoice-settings/update', 'GeneralSettingsController@invoice_update')->name('invoice_settings_update');

    Route::post('sms-gateway-credentials/update', 'GeneralSettingsController@sms_gateway_credentials_update')->name('sms_gateway_credentials_update');
    Route::post('template/update', 'GeneralSettingsController@template_update')->name('template_update');
    Route::post('general-setting-footer/update', 'GeneralSettingsController@footer_update')->name('general_setting_footer_update');
    Route::post('smtp-gateway-credentials/update', 'GeneralSettingsController@smtp_gateway_credentials_update')->name('smtp_gateway_credentials_update')->middleware('prohibited.demo.mode');

    Route::post('sms-demo-send', 'GeneralSettingsController@sms_send_demo')->name('sms_send_demo');
    Route::post('/test-mail/send', 'GeneralSettingsController@test_mail_send')->name('test_mail.send');

    Route::get('currencies', 'CurrencyController@index')->name('currencies.index');
    Route::post('currencies', 'CurrencyController@store')->name('currencies.store');
    Route::put('currencies/{id}', 'CurrencyController@update')->name('currencies.update');
    Route::get('currencies/{id}', 'CurrencyController@index')->name('currencies.show');
    Route::post('currency-edit-modal', 'CurrencyController@edit_modal')->name('currencies.edit');
    Route::get('/currencies/destroy/{id}', 'CurrencyController@destroy')->name('currencies.destroy');
    Route::get('/search', 'CurrencyController@index')->name('currencies.search_index');

    Route::get('payment-method-settings', 'PaymentGatewayController@index')->name('payment-method-settings');
    Route::put('update-payment-method-settings/{id}', 'PaymentGatewayController@update')->name('update-payment-method-settings')->middleware('prohibited.demo.mode');
    Route::post('update-active-method', 'PaymentGatewayController@updateActive')->name('update-active-method')->middleware('prohibited.demo.mode');

    Route::get('/updateSystem', 'UpdateController@updatesystem')->name('setting.updatesystem');
    Route::post('/updateSystem', 'UpdateController@updatesystemsubmit')->name('setting.updateSystem.submit1')->middleware('prohibited.demo.mode');

    Route::get('/remove/{type}', 'GeneralSettingsController@remove')->name('setting.remove');
});

Route::prefix('style')->middleware('auth')->group(function (): void {
    Route::get('themes/change_view', 'GeneralSettingsController@change_view')->name('themes.change_view');
    Route::post('themes/change_view', 'GeneralSettingsController@post_change_view');

    Route::get('/update-bg', 'GeneralSettingsController@update_bg')->name('guest-background');
    Route::post('/update-bg', 'GeneralSettingsController@post_update_bg');

    Route::get('themes/{theme}/copy', 'ThemesController@copy')->name('themes.copy');
    Route::get('themes/{theme}/default', 'ThemesController@default')->name('themes.default');
    Route::resource('themes', 'ThemesController');
});
