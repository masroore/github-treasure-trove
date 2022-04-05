<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application Services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        if (env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
