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

//
// Test routes
//
Route::get('/login-as', 'Front\HomeController@loginAs')->name('login.as');

// BACK routes.
Auth::routes();

Route::middleware('auth', 'noCustomers')->group(function (): void {
    //
    // Admin Group
    Route::prefix('admin')->group(function (): void {
        //Dashboard
        Route::get('/dashboard', 'Back\DashboardController@index')->name('dashboard');
        Route::get('/dashboard/test', 'Back\DashboardController@test')->name('dashboard.test');
        Route::get('/dashboard/test2', 'Back\DashboardController@testTwo')->name('dashboard.test2');
        Route::get('/dashboard/test3', 'Back\DashboardController@testThree')->name('dashboard.test3');
        // Categories
        Route::get('categories', 'Back\CategoryController@index')->name('categories');
        Route::middleware('strike.editor')->group(function (): void {
            Route::get('category/create', 'Back\CategoryController@create')->name('category.create');
            Route::post('category', 'Back\CategoryController@store')->name('category.store');
            Route::get('category/{category}/edit', 'Back\CategoryController@edit')->name('category.edit');
            Route::patch('category/{category}', 'Back\CategoryController@update')->name('category.update');
        });
        // MARKETING Group
        Route::prefix('marketing')->group(function (): void {
            // Sliders
            Route::prefix('sliders')->group(function (): void {
                Route::get('/', 'Back\Marketing\SliderController@index')->name('sliders');
                Route::get('create', 'Back\Marketing\SliderController@create')->name('slider.create');
                Route::post('/', 'Back\Marketing\SliderController@store')->name('slider.store');
                Route::get('{id}/edit', 'Back\Marketing\SliderController@edit')->name('slider.edit');
                Route::patch('{id}', 'Back\Marketing\SliderController@update')->name('slider.update');

                Route::prefix('{id}/edit')->group(function (): void {
                    Route::get('individual/create', 'Back\Marketing\SliderIndividualController@create')->name('slider.individual.create');
                    Route::post('individual/', 'Back\Marketing\SliderIndividualController@store')->name('slider.individual.store');
                    Route::get('individual/{sid}/edit', 'Back\Marketing\SliderIndividualController@edit')->name('slider.individual.edit');
                    Route::patch('individual/{sid}', 'Back\Marketing\SliderIndividualController@update')->name('slider.individual.update');
                });
            });
            // CUSTOM - PRICES
            Route::get('prices', 'Back\Custom\PricesController@index')->name('prices');
            Route::middleware('strike.editor')->group(function (): void {
                Route::get('price/create', 'Back\Custom\PricesController@create')->name('price.create');
                Route::post('price', 'Back\Custom\PricesController@store')->name('price.store');
                Route::get('price/{price}/edit', 'Back\Custom\PricesController@edit')->name('price.edit');
                Route::patch('price/{price}', 'Back\Custom\PricesController@update')->name('price.update');
            });

            Route::get('slider/{id}/edit/sliders', 'Back\Marketing\SliderController@editSliders')->name('slider.edit.sliders');
            // Blogs
            Route::get('/blogs', 'Back\Marketing\BlogController@index')->name('blogs');
            Route::get('/blog/create', 'Back\Marketing\BlogController@create')->name('blog.create');
            Route::post('/blog', 'Back\Marketing\BlogController@store')->name('blog.store');
            Route::get('/blog/{blog}/edit', 'Back\Marketing\BlogController@edit')->name('blog.edit');
            Route::patch('blog/{blog}', 'Back\Marketing\BlogController@update')->name('blog.update');
        });
        // USERS Group
        Route::prefix('users')->group(function (): void {
            // Users
            Route::get('users', 'Back\Users\UserController@index')->name('users');
            Route::get('user/create', 'Back\Users\UserController@create')->name('user.create');
            Route::post('user', 'Back\Users\UserController@store')->name('user.store');
            Route::get('user/{id}', 'Back\Users\UserController@show')->name('user.show');
            Route::get('user/{id}/edit', 'Back\Users\UserController@edit')->name('user.edit');
            Route::patch('user/{user}', 'Back\Users\UserController@update')->name('user.update');
            Route::get('user/{id}/edit/users', 'Back\Users\UserController@editSliders')->name('user.edit.users');
            // Messages
            Route::get('messages', 'Back\Users\MessageController@index')->name('messages');
            Route::get('message/create', 'Back\Users\MessageController@create')->name('message.create');
            Route::post('message', 'Back\Users\MessageController@send')->name('message.send');
            Route::get('message/{message}/edit', 'Back\Users\MessageController@edit')->name('message.edit');
        });
        //
        // APP SETTINGS
        // DESIGN GROUP
        Route::prefix('design')->group(function (): void {
            //
            // WIDGETS
            Route::prefix('widgets')->group(function (): void {
                Route::get('/', 'Back\Design\WidgetController@index')->name('widgets');
                Route::get('create', 'Back\Design\WidgetController@create')->name('widget.create');
                Route::post('/', 'Back\Design\WidgetController@store')->name('widget.store');
                Route::get('{widget}/edit', 'Back\Design\WidgetController@edit')->name('widget.edit');
                Route::patch('{widget}', 'Back\Design\WidgetController@update')->name('widget.update');
                // GROUP
                Route::prefix('groups')->group(function (): void {
                    Route::get('create', 'Back\Design\WidgetGroupController@create')->name('widget.group.create');
                    Route::post('/', 'Back\Design\WidgetGroupController@store')->name('widget.group.store');
                    Route::get('{widget}/edit', 'Back\Design\WidgetGroupController@edit')->name('widget.group.edit');
                    Route::patch('{widget}', 'Back\Design\WidgetGroupController@update')->name('widget.group.update');
                });
            });
        });
        //
        // SETTINGS Group
        Route::prefix('settings')->group(function (): void {
            // Profile
            Route::get('profile', 'Back\Settings\ProfileController@index')->name('profile');
            Route::patch('profile/{profile}', 'Back\Settings\ProfileController@update')->name('profile.update');
            // Pages
            Route::get('pages', 'Back\Settings\PageController@index')->name('pages');
            Route::get('page/create', 'Back\Settings\PageController@create')->name('page.create');
            Route::post('page', 'Back\Settings\PageController@store')->name('page.store');
            Route::get('page/{id}/edit', 'Back\Settings\PageController@edit')->name('page.edit');
            Route::patch('page/{page}', 'Back\Settings\PageController@update')->name('page.update');
            // APPLICATION
            Route::prefix('application')->group(function (): void {
                // THEME
                Route::get('theme', 'Back\Settings\ThemeController@index')->name('theme');
                // INFO DATA
                Route::get('info', 'Back\Settings\InfoController@index')->name('info');
                Route::post('info', 'Back\Settings\InfoController@update')->name('info.update');
            });
        });
        //
        // Back API routes.
        Route::prefix('apiv1')->group(function (): void {
            Route::prefix('pages')->group(function (): void {
                Route::post('gallery/image/destroy', 'Back\Settings\PageController@galleryUpload')->name('page.gallery.image.destroy');

                Route::post('block/destroy', 'Back\Settings\PageController@blockDestroy')->name('page.block.destroy');
            });
            // Delete routes (javascript POST)
            Route::post('category/destroy', 'Back\CategoryController@destroy')->name('category.destroy');
            Route::post('blog/destroy', 'Back\Marketing\BlogController@destroy')->name('blog.destroy');
            Route::post('slider/destroy', 'Back\Marketing\SliderController@destroy')->name('slider.destroy');
            Route::post('user/destroy', 'Back\Users\UserController@destroy')->name('user.destroy');
            Route::post('page/destroy', 'Back\Settings\PageController@destroy')->name('page.destroy');
            Route::post('price/destroy', 'Back\Custom\PricesController@destroy')->name('price.destroy');
            // WIDGET
            Route::prefix('widget')->group(function (): void {
                Route::post('destroy', 'Back\Design\WidgetController@destroy')->name('widget.destroy');
                Route::get('get-links', 'Back\Design\WidgetController@getLinks')->name('widget.api.get-links');
            });
            // Autocomplete and Autosuggestion routes
            Route::get('/users/autocomplete', 'Back\Api1\UserController@autocomplete')->name('users.autocomplete');
            // Sliders
            Route::get('/sliders/{group}/get', 'Back\Api1\SliderController@get')->name('api.sliders.get');
            Route::post('/sliders/store', 'Back\Api1\SliderController@store')->name('api.sliders.store');
            // Notifications
            Route::post('notifications/read', 'Back\Api1\UserController@notificationsRead')->name('notifications.read');
            // Charts
            Route::prefix('chart')->group(function (): void {
                Route::post('orders/bar', 'Back\Api1\ChartController@orders')->name('chart.bar.orders');
                Route::post('products/bar/horizontal', 'Back\Api1\ChartController@products')->name('chart.bar.products');
                Route::post('orders/pie/status', 'Back\Api1\ChartController@ordersStatus')->name('chart.pie.order.status');
                Route::get('stats/totals', 'Back\Api1\ChartController@totals')->name('stats.total');
            });
            // Clear Cache
            Route::prefix('cache')->group(function (): void {
                Route::get('/', 'Back\Api1\SettingController@cache')->name('cache');
                Route::get('config', 'Back\Api1\SettingController@clearConfigCache')->name('config.clear');
                Route::get('views', 'Back\Api1\SettingController@clearViewsCache')->name('views.clear');
                Route::get('routes', 'Back\Api1\SettingController@clearRoutesCache')->name('routes.clear');
            });
            // Maintenance Mode
            Route::prefix('maintenance')->group(function (): void {
                Route::get('on', 'Back\Api1\SettingController@maintenanceModeON')->name('maintenance.on');
                Route::get('off', 'Back\Api1\SettingController@maintenanceModeOFF')->name('maintenance.off');
            });
            // Maintenance Mode
            Route::prefix('settings')->group(function (): void {
                Route::get('on', 'Back\Api1\SettingController@sidebarInverseToggle')->name('sidebar.inverse.toggle');
            });
            // Images Upload
            Route::prefix('images')->group(function (): void {
                Route::post('/upload/temporary', 'Back\Api1\ImagesController@imagesUploadTemporary')->name('images.upload.temp');
                Route::post('/upload', 'Back\Api1\ImagesController@imagesUpload')->name('images.upload');
                Route::post('/upload/edited', 'Back\Api1\ImagesController@imagesUploadEdited')->name('images.upload.edited');
                Route::post('/destroy', 'Back\Api1\ImagesController@destroy')->name('images.destroy');
                Route::post('/set/default', 'Back\Api1\ImagesController@setDefault')->name('images.set.default');
            });
        });
    });
});

//
// FRONT API routes
//
Route::prefix('api/v1')->group(function (): void {
    Route::get('/user', 'Api\v1\CartController@getUser')->name('api.user');
    Route::get('trazi', 'Api\v1\SearchController@index')->name('api.search');
});
Route::get('pretraga', 'Api\v1\SearchController@all')->name('search.all');

//
// FRONT routes
//
Route::get('/', 'Front\HomeController@index')->name('index');
Route::get('sitemap.xml', 'Front\HomeController@sitemap')->name('sitemap');

Route::post('kontakt-poruka', 'Front\HomeController@proccessContactMessage')->name('kontakt.send');

Route::get('korisnik', 'Front\CustomerController@index')->name('moj');
Route::get('korisnik/promjeni', 'Front\CustomerController@edit')->name('moj.edit');
Route::post('korisnik/promjeni', 'Front\CustomerController@update')->name('moj.update');
Route::get('korisnik/poruke', 'Front\CustomerController@messages')->name('moj.poruke');
Route::get('korisnik/poruka/nova', 'Front\CustomerController@newMessage')->name('moj.poruka.nova');
Route::get('korisnik/poruka/{message}', 'Front\CustomerController@viewMessage')->name('moj.poruka');
Route::post('korisnik/poruka', 'Front\CustomerController@sendMessage')->name('moj.poruka.send');
Route::get('moj-racun/zahtjev', 'Front\CustomerController@sendRequest')->name('moj.zahtjev.request');

Route::get('lista-projekata', 'Front\PageController@projectList')->name('project.list');
Route::get('{cat}/{subcat?}/{page?}', 'Front\PageController@index')->name('page');

// Front TEST routes.
Route::prefix('temp')->group(function (): void {
    Route::get('/customer/dashboard', 'Back\DashboardController@tempCustomerDashboard')->name('customer.dashboard');
});
