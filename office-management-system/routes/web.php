<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//For Downloading Files
Route::get('/file-download/{fileName}', 'HomeController@fileDownload')->name('file.download');

Route::get('/', 'FrontendController@index')->name('main.page');

Auth::routes(['verify' => true, 'register' => true]);

Route::post('/resend', '\App\Http\Controllers\Auth\VerificationController@resend_mail')->name('verification_mail_resend');
Route::group(['middleware' => ['auth']], function (): void {
    Route::view('team-html', 'team');
    Route::view('project-default', 'project-default');
    Route::view('project-html', 'project');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::post('/menu-search', 'HomeController@menuSearch')->name('menu.search');

    Route::middleware('permission')->prefix('hr')->group(function (): void {
        Route::resource('staffs', 'StaffController')->except('destroy');
        Route::post('/staff-status-update', 'StaffController@status_update')->name('staffs.update_active_status')->middleware('prohibited.demo.mode');
        Route::get('/staff/view/{id}', 'StaffController@show')->name('staffs.view');
        Route::get('/staff/report-print/{id}', 'StaffController@report_print')->name('staffs.report_print');
        Route::get('/staff/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');

        Route::get('/staff/csv-upload-page', 'StaffController@csv_upload')->name('staffs.csv_upload');
        Route::post('/staff/csv-upload-store', 'StaffController@csv_upload_store')->name('staffs.csv_upload_store');
    });

    Route::post('/staff-document/store', 'StaffController@document_store')->name('staff_document.store');
    Route::get('/staff-document/destroy/{id}', 'StaffController@document_destroy')->name('staff_document.destroy');
    Route::get('/profile-view', 'StaffController@profile_view')->name('profile_view');
    Route::post('/profile-edit', 'StaffController@profile_edit')->name('profile_edit_modal');
    Route::post('/profile-update/{id}', 'StaffController@profile_update')->name('profile.update');
    Route::get('/company_info', 'HomeController@company')->name('company_info');
    Route::post('/dashboard-cards-info/{type}', 'HomeController@dashboardCards')->name('dashboard.card.info');
    Route::post('/notification/update', 'HomeController@notificationUpdate')->name('notification.update');

    Route::get('notification-lists', 'HomeController@notification_list')->name('all_notifications');
    Route::get('notification-read-all', 'HomeController@notification_read_all')->name('mark_notifications');
    Route::post('notification-read-all', 'HomeController@post_notification_read_all');

    Route::get('/change-password', 'HomeController@change_password')->name('change_password');
    Route::post('/change-password', 'HomeController@post_change_password');
});
