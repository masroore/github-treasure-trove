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
        Commands\ActualizarBusquedas::class,
        Commands\ConsultarResultadosFacebook::class,
        Commands\EjecutarBusquedasOnboarding::class,
        Commands\CodigosPendientesFacebook::class,
        Commands\ActualizarClientesOnboarding::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $url_base = env('APP_URL');
        if ($url_base == 'http://localhost:8000') {//Estoy en local
            //$schedule->command('Actualizar_Busquedas')->daily();
            $schedule->command('Actualizar_Clientes_Onboarding')->dailyAt('08:00');
            $schedule->command('Codigos_Pendientes_Facebook')->everyMinute()->withoutOverlapping();
            $schedule->command('Ejecutar_Busquedas_Onboarding')->everyMinute()->withoutOverlapping();
            $schedule->command('Consultar_Resultados_Facebook')->cron('*/20 * * * *');
        }
        if ($url_base == 'https://test.birs.cloud') {//Estoy en Test
            //$schedule->command('Actualizar_Busquedas')->daily();
            //$schedule->command('Actualizar_Clientes_Onboarding')->dailyAt('08:00');
            $schedule->command('Codigos_Pendientes_Facebook')->everyMinute()->withoutOverlapping();
            $schedule->command('Ejecutar_Busquedas_Onboarding')->everyMinute()->withoutOverlapping();
            $schedule->command('Consultar_Resultados_Facebook')->cron('*/20 * * * *');
        }
        if ($url_base == 'https://birs.cloud') {//Estoy en Produccion
            //$schedule->command('Actualizar_Busquedas')->daily();
            $schedule->command('Actualizar_Clientes_Onboarding')->dailyAt('08:00');
            $schedule->command('Codigos_Pendientes_Facebook')->everyMinute()->withoutOverlapping();
            $schedule->command('Ejecutar_Busquedas_Onboarding')->everyMinute()->withoutOverlapping();
            $schedule->command('Consultar_Resultados_Facebook')->cron('*/20 * * * *');
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
