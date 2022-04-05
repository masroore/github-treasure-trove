<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function (): void {
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

    // Kecamatan
    Route::delete('kecamatans/destroy', 'KecamatanController@massDestroy')->name('kecamatans.massDestroy');
    Route::resource('kecamatans', 'KecamatanController');

    // Kelurahan
    Route::delete('kelurahans/destroy', 'KelurahanController@massDestroy')->name('kelurahans.massDestroy');
    Route::resource('kelurahans', 'KelurahanController');

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoryController@storeMedia')->name('categories.storeMedia');
    Route::post('categories/ckmedia', 'CategoryController@storeCKEditorImages')->name('categories.storeCKEditorImages');
    Route::resource('categories', 'CategoryController');

    // Build
    Route::delete('builds/destroy', 'BuildController@massDestroy')->name('builds.massDestroy');
    Route::post('builds/parse-csv-import', 'BuildController@parseCsvImport')->name('builds.parseCsvImport');
    Route::post('builds/process-csv-import', 'BuildController@processCsvImport')->name('builds.processCsvImport');
    Route::resource('builds', 'BuildController');

    // Nsup
    Route::delete('nsups/destroy', 'NsupController@massDestroy')->name('nsups.massDestroy');
    Route::post('nsups/parse-csv-import', 'NsupController@parseCsvImport')->name('nsups.parseCsvImport');
    Route::post('nsups/process-csv-import', 'NsupController@processCsvImport')->name('nsups.processCsvImport');
    Route::resource('nsups', 'NsupController');

    // Ipal
    Route::delete('ipals/destroy', 'IpalController@massDestroy')->name('ipals.massDestroy');
    Route::post('ipals/media', 'IpalController@storeMedia')->name('ipals.storeMedia');
    Route::post('ipals/ckmedia', 'IpalController@storeCKEditorImages')->name('ipals.storeCKEditorImages');
    Route::post('ipals/parse-csv-import', 'IpalController@parseCsvImport')->name('ipals.parseCsvImport');
    Route::post('ipals/process-csv-import', 'IpalController@processCsvImport')->name('ipals.processCsvImport');
    Route::resource('ipals', 'IpalController');

    // Build Gallery
    Route::delete('build-galleries/destroy', 'BuildGalleryController@massDestroy')->name('build-galleries.massDestroy');
    Route::post('build-galleries/media', 'BuildGalleryController@storeMedia')->name('build-galleries.storeMedia');
    Route::post('build-galleries/ckmedia', 'BuildGalleryController@storeCKEditorImages')->name('build-galleries.storeCKEditorImages');
    Route::resource('build-galleries', 'BuildGalleryController');

    // Density
    Route::delete('densities/destroy', 'DensityController@massDestroy')->name('densities.massDestroy');
    Route::post('densities/parse-csv-import', 'DensityController@parseCsvImport')->name('densities.parseCsvImport');
    Route::post('densities/process-csv-import', 'DensityController@processCsvImport')->name('densities.processCsvImport');
    Route::resource('densities', 'DensityController');

    // Sanitation
    Route::post('sanitations/parse-csv-import', 'SanitationController@parseCsvImport')->name('sanitations.parseCsvImport');
    Route::post('sanitations/process-csv-import', 'SanitationController@processCsvImport')->name('sanitations.processCsvImport');
    Route::resource('sanitations', 'SanitationController', ['except' => ['destroy']]);

    // Risk
    Route::post('risks/parse-csv-import', 'RiskController@parseCsvImport')->name('risks.parseCsvImport');
    Route::post('risks/process-csv-import', 'RiskController@processCsvImport')->name('risks.processCsvImport');
    Route::resource('risks', 'RiskController', ['except' => ['show', 'destroy']]);

    // Secured
    Route::post('secureds/parse-csv-import', 'SecuredController@parseCsvImport')->name('secureds.parseCsvImport');
    Route::post('secureds/process-csv-import', 'SecuredController@processCsvImport')->name('secureds.processCsvImport');
    Route::resource('secureds', 'SecuredController', ['except' => ['destroy']]);

    // Content Category
    Route::delete('content-categories/destroy', 'ContentCategoryController@massDestroy')->name('content-categories.massDestroy');
    Route::resource('content-categories', 'ContentCategoryController');

    // Content Tag
    Route::delete('content-tags/destroy', 'ContentTagController@massDestroy')->name('content-tags.massDestroy');
    Route::resource('content-tags', 'ContentTagController');

    // Content Page
    Route::delete('content-pages/destroy', 'ContentPageController@massDestroy')->name('content-pages.massDestroy');
    Route::post('content-pages/media', 'ContentPageController@storeMedia')->name('content-pages.storeMedia');
    Route::post('content-pages/ckmedia', 'ContentPageController@storeCKEditorImages')->name('content-pages.storeCKEditorImages');
    Route::resource('content-pages', 'ContentPageController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Task Status
    Route::delete('task-statuses/destroy', 'TaskStatusController@massDestroy')->name('task-statuses.massDestroy');
    Route::resource('task-statuses', 'TaskStatusController');

    // Task Tag
    Route::delete('task-tags/destroy', 'TaskTagController@massDestroy')->name('task-tags.massDestroy');
    Route::resource('task-tags', 'TaskTagController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Tasks Calendar
    Route::resource('tasks-calendars', 'TasksCalendarController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Infographic
    Route::delete('infographics/destroy', 'InfographicController@massDestroy')->name('infographics.massDestroy');
    Route::post('infographics/media', 'InfographicController@storeMedia')->name('infographics.storeMedia');
    Route::post('infographics/ckmedia', 'InfographicController@storeCKEditorImages')->name('infographics.storeCKEditorImages');
    Route::resource('infographics', 'InfographicController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function (): void {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
