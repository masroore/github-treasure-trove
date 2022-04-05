<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginSecurityController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::group(['middleware' => ['auth', 'xss', 'setting', '2fa']], function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('modules', ModuleController::class);
    Route::resource('profile', ProfileController::class);

    Route::post('/role/{id}', [RoleController::class, 'assignPermission'])->name('roles_permit');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings/app-name/update', [SettingsController::class, 'appNameUpdate'])->name('settings/app-name/update');
    Route::post('settings/app-logo/update', [SettingsController::class, 'appNameUpdate'])->name('settings/app-name/update');
    Route::post('settings/pusher-setting/update', [SettingsController::class, 'pusherSettingUpdate'])->name('settings/pusher-setting/update');
    Route::post('settings/s3-setting/update', [SettingsController::class, 's3SettingUpdate'])->name('settings/s3-setting/update');
    Route::post('settings/email-setting/update', [SettingsController::class, 'emailSettingUpdate'])->name('settings/email-setting/update');
    Route::post('settings/auth-settings/update', [SettingsController::class, 'authSettingsUpdate'])->name('settings/auth-settings/update');
    Route::get('setting/{id}', [SettingsController::class, 'loadsetting'])->name('setting');
    Route::post('test-mail', [SettingsController::class, 'testSendMail'])->name('test.send.mail');

    Route::get('update-avatar/{id}', [ProfileController::class, 'showAvatar'])->name('update-avatar');
    Route::get('design/{id}', [ProfileController::class, 'design'])->name('forms.design');
    Route::post('update-profile-login/{id}', [ProfileController::class, 'updateLogin'])->name('update-login');
    Route::post('/verify-2fa', [ProfileController::class, 'verify'])->name('verify-2fa');
    Route::post('/activate-2fa', [ProfileController::class, 'activate'])->name('activate-2fa');
    Route::post('/enable-2fa', [ProfileController::class, 'enable'])->name('enable-2fa');
    Route::post('/disable-2fa', [ProfileController::class, 'disable'])->name('disable-2fa');
    Route::get('/2fa/instruction', [ProfileController::class, 'instruction']);

    Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language');
    Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language');
    Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data');
    Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language');
    Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language');
    Route::delete('/lang/{lang}', [LanguageController::class, 'destroyLang'])->name('lang.destroy');
    Route::get('language', [LanguageController::class, 'index'])->name('index');

    Route::group(['prefix' => '2fa'], function (): void {
        Route::get('/', [LoginSecurityController::class, 'show2faForm']);
        Route::post('/generateSecret', [LoginSecurityController::class, 'generate2faSecret'])->name('generate2faSecret');
        Route::post('/enable2fa', [LoginSecurityController::class, 'enable2fa'])->name('enable2fa');
        Route::post('/disable2fa', [LoginSecurityController::class, 'disable2fa'])->name('disable2fa');

        // 2fa middleware
        Route::post('/2faVerify', function () {
            return redirect(URL()->previous());
        })->name('2faVerify')->middleware('2fa');
    });
});
