<?php

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

Route::get('/', function () {
    return view('welcome');
})->name('/');

Auth::routes(['verify' => true]);

Route::get('/2fa/validate', [App\Http\Controllers\Auth\LoginController::class, 'getValidateToken'])->name('2fa');
Route::post('/2fa/validate', [App\Http\Controllers\Auth\LoginController::class, 'postValidateToken'])->name('2fa.validate');

Route::get('/lang/{locale}', [App\Http\Controllers\LanguageController::class, 'setLocale'])->name('lang');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/exchange', [App\Http\Controllers\ExchangeController::class, 'index'])->name('exchange');
Route::post('/exchange/balance', [App\Http\Controllers\ExchangeController::class, 'getCurrentBalance'])->name('exchange.balance');
Route::post('/exchange/order/history', [App\Http\Controllers\ExchangeController::class, 'getOrderHistory'])->name('exchange.order.history');
Route::post('/exchange/trade/history', [App\Http\Controllers\ExchangeController::class, 'getTradeHistory'])->name('exchange.trade.history');
Route::post('/exchange/order', [App\Http\Controllers\ExchangeController::class, 'order'])->name('exchange.order');
Route::post('/exchange/order/cancel', [App\Http\Controllers\ExchangeController::class, 'orderCancel'])->name('exchange.order.cancel');

Route::get('/dealer', [App\Http\Controllers\DealerController::class, 'index'])->name('dealer');
Route::post('/dealer/trade/list', [App\Http\Controllers\DealerController::class, 'getTradeList'])->name('dealer.trade.list');

Route::get('/rate', [App\Http\Controllers\RateController::class, 'get_rate'])->name('rate.interval');
Route::get('/dealer/rate', [App\Http\Controllers\RateController::class, 'get_dealer_rate'])->name('dealer.rate.interval');

Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
Route::post('/withdraw', [App\Http\Controllers\PaymentController::class, 'withdraw'])->name('payment.withdraw');

Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('report');
Route::post('/report/trade/history', [App\Http\Controllers\ReportController::class, 'getTradeHistory'])->name('report.trade.history');
Route::post('/report/deposit/history', [App\Http\Controllers\ReportController::class, 'getDepositHistory'])->name('report.deposit.history');
Route::post('/report/withdraw/history', [App\Http\Controllers\ReportController::class, 'getWithdrawHistory'])->name('report.withdraw.history');

Route::get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting');
Route::post('/setting/updateprofile', [App\Http\Controllers\SettingController::class, 'updateProfile'])->name('setting.updateprofile');
Route::post('/setting/updatepassword', [App\Http\Controllers\SettingController::class, 'updatePassword'])->name('setting.updatepassword');
Route::post('/setting/idverify', [App\Http\Controllers\SettingController::class, 'idVerify'])->name('setting.idverify');
Route::post('/setting/idverify/delete', [App\Http\Controllers\SettingController::class, 'idVerifyDelete'])->name('setting.idverify.delete');
Route::post('/setting/2fa_auth/enable', [App\Http\Controllers\SettingController::class, 'enable2FA'])->name('setting.2fa_auth.enable');
Route::post('/setting/2fa_auth/disable', [App\Http\Controllers\SettingController::class, 'disable2FA'])->name('setting.2fa_auth.disable');
Route::post('/setting/datalist', [App\Http\Controllers\SettingController::class, 'getDataList'])->name('setting.datalist');
Route::post('/setting/loginhistory', [App\Http\Controllers\SettingController::class, 'getLoginHistory'])->name('setting.loginhistory');
Route::post('/setting/language', [App\Http\Controllers\SettingController::class, 'language'])->name('setting.language');

Route::get('/faq', [App\Http\Controllers\FAQController::class, 'index'])->name('faq');
Route::get('/faq/{id}', [App\Http\Controllers\FAQController::class, 'getFaqList'])->name('faq.list');

Route::get('/contactus', [App\Http\Controllers\ContactUsController::class, 'index'])->name('contactus');
Route::post('/contactus/send', [App\Http\Controllers\ContactUsController::class, 'send'])->name('contactus.send');

Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news');
Route::post('/news/list', [App\Http\Controllers\NewsController::class, 'getNewsList'])->name('news.list');
Route::get('/news/detail/{id}', [App\Http\Controllers\NewsController::class, 'newsDetail'])->name('news.detail');

Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/list', [App\Http\Controllers\NotificationController::class, 'getNotificationsList'])->name('notifications.list');
Route::get('/notifications/detail/{id}', [App\Http\Controllers\NotificationController::class, 'notificationDetail'])->name('notifications.detail');

Route::get('/maintenance', [App\Http\Controllers\MaintenanceController::class, 'index'])->name('maintenance');
