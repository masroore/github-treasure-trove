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

use Hifone\Console\Commands\InstallCommand;
use Hifone\Console\Commands\ResetCommand;
use Hifone\Console\Commands\SeedCommand;
use Hifone\Console\Commands\Subscribers\CommandSubscriber;
use Hifone\Console\Commands\UpdateCommand;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->commands('command.hifone_update', 'command.hifone_install', 'command.hifone_reset', 'command.hifone_seed');

        $this->setupListeners();
    }

    /**
     * Setup the listeners.
     */
    protected function setupListeners(): void
    {
        $subscriber = $this->app->make(CommandSubscriber::class);

        $this->app->events->subscribe($subscriber);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerUpdateCommand();
        $this->registerInstallCommand();
        $this->registerResetCommand();
        $this->registerSeedCommand();
    }

    /**
     * Register the updated command class.
     */
    protected function registerUpdateCommand(): void
    {
        $this->app->singleton('command.hifone_update', function (Container $app) {
            $events = $app['events'];

            return new UpdateCommand($events);
        });
    }

    /**
     * Register the install command class.
     */
    protected function registerInstallCommand(): void
    {
        $this->app->singleton('command.hifone_install', function (Container $app) {
            $events = $app['events'];

            return new InstallCommand($events);
        });
    }

    /**
     * Register the reset command class.
     */
    protected function registerResetCommand(): void
    {
        $this->app->singleton('command.hifone_reset', function (Container $app) {
            $events = $app['events'];

            return new ResetCommand($events);
        });
    }

    /**
     * Register the seed command class.
     */
    protected function registerSeedCommand(): void
    {
        $this->app->singleton('command.hifone_seed', function (Container $app) {
            $events = $app['events'];

            return new SeedCommand($events);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'command.hifone_update',
            'command.hifone_install',
            'command.hifone_reset',
            'command.hifone_seed',
        ];
    }
}
