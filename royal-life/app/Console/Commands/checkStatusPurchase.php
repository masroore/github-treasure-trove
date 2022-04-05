<?php

namespace App\Console\Commands;

use App\Http\Controllers\TiendaController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class checkStatusPurchase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkstatus:purchase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite verificar el estado de las compras procesadas';

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
        Log::info('Inciar Comando checkStatusPurchase ' . Carbon::now()->format('Y-m-d'));

        $tiendaController = new TiendaController();
        $tiendaController->checkStatusOrden();
        Log::info('Actualizo las ordenes ' . Carbon::now()->format('Y-m-d'));
        $tiendaController->activarUser();
        Log::info('Activo a los usuarios ' . Carbon::now()->format('Y-m-d'));
        Log::info('Fin Comando checkStatusPurchase ' . Carbon::now()->format('Y-m-d'));
    }
}
