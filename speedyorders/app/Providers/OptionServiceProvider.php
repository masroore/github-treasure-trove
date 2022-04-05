<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OptionServiceProvider extends ServiceProvider
{
    /**
     * Register Services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap Services.
     */
    public function boot(): void
    {
        require_once app_path('Utils/Option.php');
    }
}
