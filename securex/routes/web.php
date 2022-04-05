<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\Modules\ModuleController;
use App\Http\Controllers\Admin\Modules\reCaptchaController;
use App\Http\Controllers\Admin\Modules\SocialLoginsController;
use App\Http\Controllers\Admin\Modules\TwoFactorAuthController;
use App\Http\Controllers\Admin\Pages\PageController;
use App\Http\Controllers\Admin\Settings\LaravelShortcutsController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Settings\SystemSettingController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuth\GithubLoginController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\User\Dashboard\DashboardController;
use App\Http\Controllers\User\Profile\NotificationController;
use App\Http\Controllers\User\Profile\ProfileController;
use App\Http\Controllers\User\Security\SecurityController;
use App\Http\Controllers\User\Vault\Folder\FolderController;
use App\Http\Controllers\User\Vault\Site\SiteController;
use App\Http\Controllers\User\Vault\VaultController;
use App\Http\Controllers\User\Vault\VaultSettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Enabling Email Verification
Auth::routes(['verify' => true]);

//Setting a GET for logout
Route::get('logout', [LoginController::class, 'logout'])->name('signOut');

// Github OAuth Routes
Route::get('login/github', [GithubLoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('login/github/callback', [GithubLoginController::class, 'handleGithubCallback']);

/** User Routes */

// Dashboard Route
Route::get('/', [DashboardController::class, 'redirect']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/announcements', [DashboardController::class, 'announcements'])->name('dashboard.announcements');

// Vault Related Routes
Route::get('/vaults', [VaultController::class, 'index'])->name('vaults');
Route::get('/vaults/{vault}', [VaultController::class, 'select'])->name('vaults.select');
Route::post('/vaults/{vault}/authenticate', [VaultController::class, 'authenticate'])->name('vaults.select.authenticate');
Route::get('/vaults/{vault}/lock', [VaultController::class, 'lockVault'])->name('vaults.select.lock');

// Vault Settings Controller Routes
Route::get('/vaults/{vault}/settings', [VaultSettingsController::class, 'index'])->name('vaults.select.settings');
Route::post('/vaults/{vault}/settings/general/store', [VaultSettingsController::class, 'storeGeneralSettings'])->name('vaults.select.settings.general.store');
Route::get('/vaults/{vault}/settings/password', [VaultSettingsController::class, 'passwordSettings'])->name('vaults.select.settings.password');
Route::post('/vaults/{vault}/settings/password/store', [VaultSettingsController::class, 'storePasswordSettings'])->name('vaults.select.settings.password.store');
Route::delete('/vaults/{vault}/settings/password/delete', [VaultSettingsController::class, 'deletePasswordSettings'])->name('vaults.select.settings.password.delete');
Route::get('/vaults/{vault}/settings/delete', [VaultSettingsController::class, 'deleteSettings'])->name('vaults.select.settings.delete');
Route::delete('/vaults/{vault}/settings/delete', [VaultSettingsController::class, 'deleteVault'])->name('vaults.select.settings.delete.vault');

// Vault Folders Routes
Route::post('/vaults/{vault}/f/store', [FolderController::class, 'store'])->name('vault.folder.store');
Route::get('/vaults/{vault}/f/{folder}', [FolderController::class, 'show'])->name('vault.folder.show');
Route::post('/vaults/{vault}/s/{site}/addToFolder', [FolderController::class, 'addToFolder'])->name('vault.folder.addToFolder');
Route::post('/vaults/{vault}/s/{site}/removeFromFolder', [FolderController::class, 'removeFromFolder'])->name('vault.folder.removeFromFolder');

// Vault Sites Routes
Route::post('/vaults/{vault}/site/store', [SiteController::class, 'store'])->name('vault.site.store');
Route::get('/vaults/{vault}/s/{site}', [SiteController::class, 'show'])->name('vault.site.show');
Route::get('/vaults/{vault}/s/{site}/edit', [SiteController::class, 'edit'])->name('vault.site.edit');
Route::post('/vaults/{vault}/s/{site}/update', [SiteController::class, 'update'])->name('vault.site.update');
Route::get('/vaults/{vault}/s/{site}/fav/set', [SiteController::class, 'storeFav'])->name('vault.site.fav.store');
Route::get('/vaults/{vault}/s/{site}/fav/delete', [SiteController::class, 'deleteFav'])->name('vault.site.fav.delete');
Route::delete('/vaults/{vault}/s/{site}', [SiteController::class, 'delete'])->name('vault.site.delete');
Route::post('/vaults/{vault}/s/{site}/move', [SiteController::class, 'move'])->name('vault.site.move');

// Profile & Settings Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
Route::delete('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');
Route::post('/profile/delete/cancel', [ProfileController::class, 'deleteCancel'])->name('profile.delete.cancel');
Route::get('/profile/ip-logs', [ProfileController::class, 'ipLogs'])->name('profile.iplogs');
Route::get('/profile/notifications', [NotificationController::class, 'index'])->name('profile.notifications');
Route::get('/profile/notifications/mark', [NotificationController::class, 'mark'])->name('profile.notifications.mark');
Route::get('/profile/notifications/delete', [NotificationController::class, 'delete'])->name('profile.notifications.delete');

// Security Routes
Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
Route::post('/security/questions/store', [SecurityController::class, 'storeQuestions'])->name('security.questions.store');
Route::post('/security/2fa/activate', [SecurityController::class, 'activate2FA'])->name('security.2fa.activate');
Route::post('/security/2fa/deactivate', [SecurityController::class, 'deactivate2FA'])->name('security.2fa.deactivate');
Route::get('/security/2fa/disable', [SecurityController::class, 'disable2FAView'])->name('security.2fa.disable');
Route::post('/security/2fa/disable', [SecurityController::class, 'disable2FA'])->name('security.2fa.disable2FA');
Route::post('/security/2fa/reset', [SecurityController::class, 'reset2FA'])->name('security.2fa.reset');

// Custom Pages Routes
Route::get('/pages/{page}', [PagesController::class, 'view'])->name('pages.view');

// Admin Dashboard Routes
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');

// Admin Page Routes
Route::get('/admin/pages', [PageController::class, 'index'])->name('admin.pages.index');
Route::get('/admin/pages/add', [PageController::class, 'add'])->name('admin.pages.add');
Route::post('/admin/pages/add', [PageController::class, 'store'])->name('admin.pages.store');
Route::get('/admin/pages/{page}/edit', [PageController::class, 'edit'])->name('admin.pages.edit');
Route::post('/admin/pages/{page}', [PageController::class, 'update'])->name('admin.pages.update');
Route::delete('/admin/pages/{page}', [PageController::class, 'delete'])->name('admin.pages.delete');

// Admin User Routes
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
Route::post('/admin/users/{user}/changeEmail', [UserController::class, 'changeEmail'])->name('admin.users.change.email');
Route::get('/admin/users/{user}/iplogs', [UserController::class, 'iplogs'])->name('admin.users.iplogs');
Route::post('/admin/users/{user}/verifyPIN', [UserController::class, 'verifyPIN'])->name('admin.users.pin.verify');
Route::post('/admin/users/{user}/ban', [UserController::class, 'ban'])->name('admin.users.ban.store');
Route::delete('/admin/users/{user}/ban', [UserController::class, 'revokeBAN'])->name('admin.users.ban.delete');
Route::post('/admin/users/create', [UserController::class, 'store'])->name('admin.users.store');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

// Admin Setting Routes
Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');

//Admin System Setting Routes
Route::get('/admin/settings/system', [SystemSettingController::class, 'index'])->name('admin.settings.system.index');
Route::post('/admin/settings/system/maintenance/down', [SystemSettingController::class, 'down'])->name('admin.settings.system.maintenance.down');
Route::post('/admin/settings/system/maintenance/up', [SystemSettingController::class, 'up'])->name('admin.settings.system.maintenance.up');
Route::post('/admin/settings/system/access/private', [SystemSettingController::class, 'private'])->name('admin.settings.system.access.private');
Route::post('/admin/settings/system/access/public', [SystemSettingController::class, 'public'])->name('admin.settings.system.access.public');
Route::post('/admin/settings/system/app', [SystemSettingController::class, 'app'])->name('admin.settings.system.app');

//Admin Laravel Shortcuts Routes
Route::get('/admin/settings/automation/laravel/clear-cache', [LaravelShortcutsController::class, 'clearCache'])->name('admin.settings.clear-cache');
Route::get('/admin/settings/automation/laravel/clear-view', [LaravelShortcutsController::class, 'clearView'])->name('admin.settings.clear-view');
Route::get('/admin/settings/automation/laravel/clear-route', [LaravelShortcutsController::class, 'clearRoute'])->name('admin.settings.clear-route');
Route::get('/admin/settings/automation/laravel/clear-config', [LaravelShortcutsController::class, 'clearConfig'])->name('admin.settings.clear-config');
Route::get('/admin/settings/automation/laravel/clear-compiled', [LaravelShortcutsController::class, 'clearCompiled'])->name('admin.settings.clear-compiled');
Route::get('/admin/settings/automation/laravel/symlink', [LaravelShortcutsController::class, 'symlink'])->name('admin.settings.symlink');

// Admin Module Routes
Route::get('/admin/modules', [ModuleController::class, 'index'])->name('admin.modules.index');
Route::get('/admin/modules/tfa', [TwoFactorAuthController::class, 'index'])->name('admin.modules.tfa.index');
Route::post('/admin/modules/tfa', [TwoFactorAuthController::class, 'update'])->name('admin.modules.tfa.update');
Route::get('/admin/modules/recaptcha', [reCaptchaController::class, 'index'])->name('admin.modules.recaptcha.index');
Route::post('/admin/modules/recaptcha', [reCaptchaController::class, 'update'])->name('admin.modules.recaptcha.update');
Route::get('/admin/modules/social', [SocialLoginsController::class, 'index'])->name('admin.modules.social.index');
Route::post('/admin/modules/social', [SocialLoginsController::class, 'update'])->name('admin.modules.social.update');
