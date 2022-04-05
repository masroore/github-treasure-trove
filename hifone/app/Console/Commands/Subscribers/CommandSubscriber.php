<?php

/*
 * This file is part of Hifone.
 *
 * (c) Hifone.com <hifone@hifone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hifone\Console\Commands\Subscribers;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;

class CommandSubscriber
{
    /**
     * The config repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen('command.generatekey', __CLASS__ . '@onGenerateKey', 5);
        $events->listen('command.cacheconfig', __CLASS__ . '@onCacheConfig', 5);
        $events->listen('command.cacheroutes', __CLASS__ . '@onCacheRoutes', 5);
        $events->listen('command.publishvendors', __CLASS__ . '@onPublishVendors', 5);
        $events->listen('command.resetmigrations', __CLASS__ . '@onResetMigrations', 5);
        $events->listen('command.runmigrations', __CLASS__ . '@onRunMigrations', 5);
        $events->listen('command.runseeding', __CLASS__ . '@onRunSeeding', 5);
        $events->listen('command.updatecache', __CLASS__ . '@onUpdateCache', 5);

        $events->listen('command.installing', __CLASS__ . '@onRunBackup', 5);
        $events->listen('command.updating', __CLASS__ . '@onRunBackup', 5);
        $events->listen('command.resetting', __CLASS__ . '@onRunBackup', 5);
    }

    /**
     * Clear the settings cache, and backup the databases.
     */
    public function onRunBackup(Command $command): void
    {
        $command->line('Clearing settings cache...');
        $command->line('Settings cache cleared!');
        $command->line('Backing up database...');

        try {
            $command->call('db:backup', [
                '--compression' => 'gzip',
                '--database' => $this->config->get('database.default'),
                '--destination' => 'local',
                '--destinationPath' => Carbon::now()->format('Y-m-d_H.i.s'),
                '--no-interaction' => true,
            ]);
        } catch (Exception $e) {
            $command->error($e->getMessage());
            $command->line('Backup skipped!');
        }
        $command->line('Backup completed!');
    }

    /**
     * Handle a command.generatekey event.
     */
    public function onGenerateKey(Command $command): void
    {
        $command->call('key:generate');
    }

    /**
     * Handle a command.cacheconfig event.
     */
    public function onCacheConfig(Command $command): void
    {
        $command->call('config:cache');
    }

    /**
     * Handle a command.cacheroutes event.
     */
    public function onCacheRoutes(Command $command): void
    {
        $command->call('route:cache');
    }

    /**
     * Handle a command.publishvendors event.
     */
    public function onPublishVendors(Command $command): void
    {
        $command->call('vendor:publish');
    }

    /**
     * Handle a command.resetmigrations event.
     */
    public function onResetMigrations(Command $command): void
    {
        $command->call('migrate:reset', ['--force' => true]);
    }

    /**
     * Handle a command.runmigrations event.
     */
    public function onRunMigrations(Command $command): void
    {
        $command->call('migrate', ['--force' => true]);
    }

    /**
     * Handle a command.runseeding event.
     */
    public function onRunSeeding(Command $command): void
    {
        $command->call('db:seed', ['--force' => true]);
    }

    /**
     * Handle a command.updatecache event.
     */
    public function onUpdateCache(Command $command): void
    {
        $command->line('Clearing cache...');
        $command->call('cache:clear');
        $command->info('Cache cleared!');
    }
}
