<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Push Notification
    Route::delete('push-notifications/destroy', 'PushNotificationController@massDestroy')->name('push-notifications.massDestroy');
    Route::resource('push-notifications', 'PushNotificationController');

    // Device
    Route::delete('devices/destroy', 'DeviceController@massDestroy')->name('devices.massDestroy');
    Route::post('devices/parse-csv-import', 'DeviceController@parseCsvImport')->name('devices.parseCsvImport');
    Route::post('devices/process-csv-import', 'DeviceController@processCsvImport')->name('devices.processCsvImport');
    Route::resource('devices', 'DeviceController', ['except' => ['create', 'store', 'edit', 'update']]);

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
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

Route::get('/notification', function () {
    $SERVER_API_KEY = 'AAAAvO9kHo4:APA91bGbCVzLul_wWug7zPJHi3YIyCVYrbcBQHB04fZoMp3Mh-SZwQceFLgSVW-CFOqSyZQuOs7crQKWHyOQGqFR6Hwj1UmDuMmmyDnxtgeQVhZJJBM4_JdwQ-OctjfeEpm-9D0E4cOt';

    $token_1 = 'cIYh2AhvTEmsa807rMXQrs:APA91bFd1tiNLQvtsZ08IUrNdqEGljGxxtGxEMm6O2yEVqa7TZokjQbOI8ksk-1_TKOrpIRbiovefRhPJ-vTX-P7NtaYwQAPpuoFC0RZACS6XXdGyh21jRvnLhFLJdE_CdygkPklPfKX';

    $data = [

        'registration_ids' => [
            $token_1,
        ],

        'notification' => [

            'title' => 'notification',

            'body' => 'Description',

            'sound'=> 'default', // required for sound on ios

        ],

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',

    ];

    $ch = curl_init();

    curl_setopt($ch, \CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, \CURLOPT_POST, true);

    curl_setopt($ch, \CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, \CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);

    dd($response);
});
