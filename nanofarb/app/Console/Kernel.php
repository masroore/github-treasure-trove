<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
//        $schedule->command('shop:product-rating-calculate', [
//            '--force'// => true,
//        ])->daily();

        if ($cron = variable('sitemap_schedule_cron')) {
            $schedule->call(function (): void {
                $sitemapManager = new \App\Managers\SitemapManager();

                $sitemapManager->store();
            })->cron($cron);
        }

        if ($cron = variable('externalshop_rozetka_import_cron')) {
            $schedule->command('external-shop:get-orders --source=rozetka --last --event');
        }

        if ($cron = variable('externalshop_prom_import_cron')) {
            $schedule->command('external-shop:get-orders --source=prom --last --event');
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
