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

use Collective\Bus\Dispatcher;
use Hifone\Pipes\UseDatabaseTransactions;
use Hifone\Services\Dates\DateFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(Dispatcher $dispatcher): void
    {
        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping($command, 'Hifone', 'Hifone\Handlers');
        });

        $dispatcher->pipeThrough([UseDatabaseTransactions::class]);

        Str::macro('canonicalize', function ($url) {
            return preg_replace('/([^\/])$/', '$1/', $url);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerDateFactory();
    }

    /**
     * Register the date factory.
     */
    protected function registerDateFactory(): void
    {
        $this->app->singleton(DateFactory::class, function ($app) {
            $appTimezone = $app->config->get('app.timezone');
            $hifoneTimezone = $app->config->get('hifone.timezone');

            return new DateFactory($appTimezone, $hifoneTimezone);
        });
    }
}
