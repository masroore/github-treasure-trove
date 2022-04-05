<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('utility', function () {
            return new \App\Facades\Utility();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
