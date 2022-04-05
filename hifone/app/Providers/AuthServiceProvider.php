<?php

/*
 * This file is part of Hifone.
 *
 * (c) Hifone.com <hifone@hifone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hifone\Providers;

use Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     */
    public function boot(GateContract $gate): void
    {
        Auth::provider('hifone', function ($app) {
            return new \Hifone\Auth\UserProvider(
                new \Hifone\Hashing\PasswordHasher(),
                \Hifone\Models\User::class
            );
        });
    }

    /**
     * Register bindings in the container.
     */
    public function register(): void
    {

    }
}
