<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OptionServiceProvider extends ServiceProvider
{
    /**
     * Register Services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap Services.
     *
     * @return void
     */
    public function boot()
    {
        require_once app_path('Utils/Option.php');
    }
}
