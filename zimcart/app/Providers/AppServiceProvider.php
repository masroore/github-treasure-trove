<?php

namespace App\Providers;

use App\SystemSetting;
use DB;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
    public function boot()
    {
        try {
            DB::connection()->getPdo();
            Schema::defaultStringLength(191);

            if (DB::connection()->getDatabaseName()) {
                if (Schema::hasTable('system_settings')) {
                    View::share('shareSettings', Cache::rememberForever('shareSettings', function () {
                        return SystemSetting::first();
                    }));
                }
            }
        } catch (Exception $ex) {
            return redirect(route('LaravelInstaller::environment'));
        }

        // Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
