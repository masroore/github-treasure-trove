<?php

namespace App\Providers;

use File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('image_server', config('site-common.image-server'));
        View::share('image_domain', config('site-common.image-domain'));

        $menus = [];
        if (File::exists(base_path('resources/laravel-admin/menus-backend.json'))) {
            $menus = json_decode(File::get(base_path('resources/laravel-admin/menus-backend.json')));
            View::share('laravelAdminMenus', $menus);
            // View::composer('admin', function ($view) use( $menus) {
          //     $view->with('laravelAdminMenus',  $menus) ;
          // });
        }
    }
}
