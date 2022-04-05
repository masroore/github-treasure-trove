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

        Commands\BinaryComision::class,
        // Commands\DaiLyComision::class,
        Commands\CheckRank::class,
        Commands\checkStatusPurchase::class,
        Commands\PagarUtilidad::class,
        Commands\CheckWithdrawCoinpayment::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('daily:comision')->everyTenMinutes();
        $schedule->command('binary:comision')->daily();
        $schedule->command('check:rank')->daily();
        $schedule->command('checkstatus:purchase')->everyTenMinutes();
        $schedule->command('checkstatus:withdraw')->daily();
        $schedule->command('pagar:utilidad')->cron('30 23 * * 1-5');
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
