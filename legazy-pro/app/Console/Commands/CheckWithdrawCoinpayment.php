<?php

namespace App\Console\Commands;

use App\Http\Controllers\LiquidactionController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckWithdrawCoinpayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkstatus:withdraw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite verificar el estado de los ultimos retiros realizados';

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
            Log::info('Inicio verificar retiros coinpayment - ' . Carbon::now());
            $liquidacion = new LiquidactionController();
            $liquidacion->checkWithDrawCoinpayment();
            Log::info('Fin de verificar retiros coinpayment - ' . Carbon::now());
        } catch (Throwable $th) {
            Log::error('Error Cron Retiros Coinpayment -> ' . $th);
        }
    }
}
