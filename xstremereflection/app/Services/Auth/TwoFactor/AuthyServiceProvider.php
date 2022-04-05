<?php

namespace Vanguard\Services\Auth\TwoFactor;

use Illuminate\Support\ServiceProvider;

class AuthyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind('authy', Authy::class);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['authy'];
    }
}
