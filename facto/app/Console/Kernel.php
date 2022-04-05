<?php

namespace App\Console;

use App\Console\Commands\ClearExpiredCommand;
use App\Console\Commands\WriteInfoCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // * * * * * cd /data/www/projects/yagong7 && php artisan schedule:run >> /dev/null 2>&1

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // ClearExpiredCommand::class,
        WriteInfoCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // $schedule->command('write:info')->everyMinute();
        // $schedule->command('write:info')->dailyAt('03:40');
        $schedule->command('backup:run')->dailyAt('04:10');
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
