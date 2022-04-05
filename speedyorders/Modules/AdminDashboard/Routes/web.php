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

use Modules\AdminDashboard\Http\Controllers\AdminDashboardController;

Route::group(['prefix' => 'admin/dashboard', 'middleware' => 'auth:admin'], function (): void {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/get-frequency-data/{frequency}', [AdminDashboardController::class, 'getFrequencyData'])->name('admin.dashboard.get.frequency.data');
});
