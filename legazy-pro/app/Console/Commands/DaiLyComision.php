<?php

namespace App\Console\Commands;

use App\Http\Controllers\WalletController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class DaiLyComision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:comision';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite pagar el bono y los puntos cada 10 min';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Log::info('Inicio de los puntos y comisiones diarias - ' . Carbon::now());
            $walletControler = new WalletController();
            $walletControler->payAll();
            Log::info('Fin de los puntos y comisiones diarias - ' . Carbon::now());
        } catch (Throwable $th) {
            Log::error('Error Cron pago diario -> ' . $th);
        }
    }
}
