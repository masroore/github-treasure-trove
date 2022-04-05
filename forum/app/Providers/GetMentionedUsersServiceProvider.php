<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class GetMentionedUsersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {

    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        App::bind('GetMentionedUsers', function () {
            return GetMentionedUsers::class;
        });
    }
}
