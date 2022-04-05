<?php

namespace App\Console\Commands;

use App\Http\Controllers\WalletController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class BinaryComision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binary:comision';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite pagar el bono binario cada dia';

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
            Log::info('Inicio del Bono Binario - ' . Carbon::now());
            $walletControler = new WalletController();
            $walletControler->bonoBinario();
            Log::info('Fin del Bono Binario - ' . Carbon::now());
        } catch (Throwable $th) {
            Log::error('Error Cron Binario -> ' . $th);
        }
    }
}
