<?php

namespace App\Console\Commands;

use App\Http\Controllers\WalletController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class PagarUtilidad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagar:utilidad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Paga las utilidades a las inversiones hasta llegar a un 200% de ganancia';

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
            Log::info('Inicio pagar utilidad diaria- ' . Carbon::now());
            $wallet = new WalletController();
            $wallet->pagarUtilidad();
            Log::info('Fin de pagar utilidad diaria - ' . Carbon::now());
        } catch (Throwable $th) {
            Log::error('Error Cron Pagar utilidad 200% -> ' . $th);
        }
    }
}
