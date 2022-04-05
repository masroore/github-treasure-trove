<?php

namespace App\Console\Commands;

use App\Models\Busqueda;
use Exception;

use Illuminate\Console\Command;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActualizarBusquedas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Actualizar_Busquedas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza todas las busquedas del sistema';

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
        $controller = resolve('App\Http\Controllers\TwitterWSController');
        $b_arr = Busqueda::all();

        $fileName = date('Y-m-d') . ' Actualizaciones de Busquedas.txt';
        $texto = '[' . date('Y-m-d H:i:s') . ']: Actualización iniciada ';
        Storage::append($fileName, $texto);

        //$espera = 0;
        foreach ($b_arr as $b) {
            /*if($espera>0){
                Storage::append($fileName,"[".date("Y-m-d H:cd i:s")."]: Esperando ".($espera/60)." Minutos");
                sleep($espera);
            }*/
            //$m1 = rand(0, 6);
            //$m2 = rand(0, 4);
            //$m3 = rand(0, 3);
            //$m4 = rand(0, 7);
            if (count($b->campañas) != 0) {
                Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Actualizando Búsqueda ' . $b->id . '...');
                $request = new Request();
                $request->palabraClave = $b->palabra_busqueda;
                $request->idBusqueda = $b->id;
                $request->fecha1 = date('Y-m-d\\TH:i:s\\Z', strtotime($b->updated_at));
                $request->fecha2 = date('Y-m-d\\TH:i:s\\Z', strtotime(date('Y-m-d H:i:s')));
                $request->uFecha1 = date('Y-m-d', strtotime($b->updated_at));
                $request->uFecha2 = date('Y-m-d', strtotime(date('Y-m-d H:i:s')));
                $request->idCampaña = ($b->campañas)->first()->id;
                $request->system_update = 'Actualizacion del sistema';

                try {
                    $funcion = $controller->losTweets($request);
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Búsqueda ' . $b->id . ' Actualizada');
                    //$espera = $m1*60+$m2*60+$m3*60+$m4*60;
                } catch (Exception $e) {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ERROR: Búsqueda ' . $b->id . ' No Actualizada');
                    Storage::append($fileName, $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
                }
                //$anx = $controller->writeSlacker($request);
                //Storage::append($fileName,$anx);
            } else {
                Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ERROR: La búsqueda ' . $b->id . ' no tiene campaña, no se pudo actualizar');
            }
        }

        $texto_success = '[' . date('Y-m-d H:i:s') . "]: Actualización finalizada\n";
        Storage::append($fileName, $texto_success);
        //return 0;
    }
}
