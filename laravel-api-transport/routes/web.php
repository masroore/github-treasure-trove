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
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('admin-users')->name('admin-users/')->group(static function (): void {
            Route::get('/', 'AdminUsersController@index')->name('index');
            Route::get('/create', 'AdminUsersController@create')->name('create');
            Route::post('/', 'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login', 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit', 'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}', 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}', 'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation', 'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::get('/profile', 'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile', 'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password', 'ProfileController@editPassword')->name('edit-password');
        Route::post('/password', 'ProfileController@updatePassword')->name('update-password');
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('users')->name('users/')->group(static function (): void {
            Route::get('/', 'UserController@index')->name('index');
            Route::get('/create', 'UserController@create')->name('create');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('/{user}/edit', 'UserController@edit')->name('edit');
            Route::post('/bulk-destroy', 'UserController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}', 'UserController@update')->name('update');
            Route::delete('/{user}', 'UserController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('posts')->name('posts/')->group(static function (): void {
            Route::get('/', 'PostsController@index')->name('index');
            Route::get('/create', 'PostsController@create')->name('create');
            Route::post('/', 'PostsController@store')->name('store');
            Route::get('/{post}/edit', 'PostsController@edit')->name('edit');
            Route::post('/bulk-destroy', 'PostsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{post}', 'PostsController@update')->name('update');
            Route::delete('/{post}', 'PostsController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('users')->name('users/')->group(static function (): void {
            Route::get('/', 'UsersController@index')->name('index');
            Route::get('/create', 'UsersController@create')->name('create');
            Route::post('/', 'UsersController@store')->name('store');
            Route::get('/{user}/edit', 'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy', 'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}', 'UsersController@update')->name('update');
            Route::delete('/{user}', 'UsersController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('cities')->name('cities/')->group(static function (): void {
            Route::get('/', 'CitiesController@index')->name('index');
            Route::get('/create', 'CitiesController@create')->name('create');
            Route::post('/', 'CitiesController@store')->name('store');
            Route::get('/{city}/edit', 'CitiesController@edit')->name('edit');
            Route::post('/bulk-destroy', 'CitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{city}', 'CitiesController@update')->name('update');
            Route::delete('/{city}', 'CitiesController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('offices')->name('offices/')->group(static function (): void {
            Route::get('/', 'OfficesController@index')->name('index');
            Route::get('/create', 'OfficesController@create')->name('create');
            Route::post('/', 'OfficesController@store')->name('store');
            Route::get('/{office}/edit', 'OfficesController@edit')->name('edit');
            Route::post('/bulk-destroy', 'OfficesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{office}', 'OfficesController@update')->name('update');
            Route::delete('/{office}', 'OfficesController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('routes')->name('routes/')->group(static function (): void {
            Route::get('/', 'RoutesController@index')->name('index');
            Route::get('/create', 'RoutesController@create')->name('create');
            Route::post('/', 'RoutesController@store')->name('store');
            Route::get('/{route}/edit', 'RoutesController@edit')->name('edit');
            Route::post('/bulk-destroy', 'RoutesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{route}', 'RoutesController@update')->name('update');
            Route::delete('/{route}', 'RoutesController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('models')->name('models/')->group(static function (): void {
            Route::get('/', 'ModelsController@index')->name('index');
            Route::get('/create', 'ModelsController@create')->name('create');
            Route::post('/', 'ModelsController@store')->name('store');
            Route::get('/{model}/edit', 'ModelsController@edit')->name('edit');
            Route::post('/bulk-destroy', 'ModelsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{model}', 'ModelsController@update')->name('update');
            Route::delete('/{model}', 'ModelsController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('transports')->name('transports/')->group(static function (): void {
            Route::get('/', 'TransportsController@index')->name('index');
            Route::get('/create', 'TransportsController@create')->name('create');
            Route::post('/', 'TransportsController@store')->name('store');
            Route::get('/{transport}/edit', 'TransportsController@edit')->name('edit');
            Route::post('/bulk-destroy', 'TransportsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{transport}', 'TransportsController@update')->name('update');
            Route::delete('/{transport}', 'TransportsController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('schedules')->name('schedules/')->group(static function (): void {
            Route::get('/', 'SchedulesController@index')->name('index');
            Route::get('/create', 'SchedulesController@create')->name('create');
            Route::post('/', 'SchedulesController@store')->name('store');
            Route::get('/{schedule}/edit', 'SchedulesController@edit')->name('edit');
            Route::post('/bulk-destroy', 'SchedulesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{schedule}', 'SchedulesController@update')->name('update');
            Route::delete('/{schedule}', 'SchedulesController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('passengers')->name('passengers/')->group(static function (): void {
            Route::get('/', 'PassengersController@index')->name('index');
            Route::get('/create', 'PassengersController@create')->name('create');
            Route::post('/', 'PassengersController@store')->name('store');
            Route::get('/{passenger}/edit', 'PassengersController@edit')->name('edit');
            Route::post('/bulk-destroy', 'PassengersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{passenger}', 'PassengersController@update')->name('update');
            Route::delete('/{passenger}', 'PassengersController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('tickets')->name('tickets/')->group(static function (): void {
            Route::get('/', 'TicketsController@index')->name('index');
            Route::get('/create', 'TicketsController@create')->name('create');
            Route::post('/', 'TicketsController@store')->name('store');
            Route::get('/{ticket}/edit', 'TicketsController@edit')->name('edit');
            Route::post('/bulk-destroy', 'TicketsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{ticket}', 'TicketsController@update')->name('update');
            Route::delete('/{ticket}', 'TicketsController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('post-users')->name('post-users/')->group(static function (): void {
            Route::get('/', 'PostUsersController@index')->name('index');
            Route::get('/create', 'PostUsersController@create')->name('create');
            Route::post('/', 'PostUsersController@store')->name('store');
            Route::get('/{postUser}/edit', 'PostUsersController@edit')->name('edit');
            Route::post('/bulk-destroy', 'PostUsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{postUser}', 'PostUsersController@update')->name('update');
            Route::delete('/{postUser}', 'PostUsersController@destroy')->name('destroy');
        });
    });
});

// Auto-generated admin routes
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function (): void {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function (): void {
        Route::prefix('office-users')->name('office-users/')->group(static function (): void {
            Route::get('/', 'OfficeUsersController@index')->name('index');
            Route::get('/create', 'OfficeUsersController@create')->name('create');
            Route::post('/', 'OfficeUsersController@store')->name('store');
            Route::get('/{officeUser}/edit', 'OfficeUsersController@edit')->name('edit');
            Route::post('/bulk-destroy', 'OfficeUsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{officeUser}', 'OfficeUsersController@update')->name('update');
            Route::delete('/{officeUser}', 'OfficeUsersController@destroy')->name('destroy');
        });
    });
});
