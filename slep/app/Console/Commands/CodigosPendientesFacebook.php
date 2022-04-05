<?php

namespace App\Console\Commands;

use App\Models\AsyncResult;
use App\Models\Busqueda;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CodigosPendientesFacebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Codigos_Pendientes_Facebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Los codigos pendientes son busquedas de facebook que aun no se ejecutan';

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
        $pending_codes_arr = AsyncResult::where('status', 'Codigo Pendiente')->get();

        $fileName = date('Y-m-d') . ' Busquedas Onboarding Facebook.txt';

        if (count($pending_codes_arr) > 0) {
            $texto = '[' . date('Y-m-d H:i:s') . ']: Ejecucion Iniciada ';
            Storage::append($fileName, $texto);

            $espera = 0;
            foreach ($pending_codes_arr as $pending_code) {
                if ($espera > 0) {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Esperando ' . $wait . ' minutos y ' . $wait_scnds . ' segundos para el siguiente...');
                    sleep($espera);
                }
                $wait = mt_rand(17, 19);
                $wait_scnds = mt_rand(1, 59);

                $busqueda = Busqueda::where('id', $pending_code->busqueda_id)->first();
                Storage::append($fileName, "\n[" . date('Y-m-d H:i:s') . ']: Buscando (Id ' . $pending_code->busqueda_id . '): ' . $busqueda->palabra_busqueda . '...');

                try {
                    $r_facebook_search = Http::get('localhost:3015/rfb/buscar/' . $busqueda->palabra_busqueda);
                    $asyncDataRFB = json_decode($r_facebook_search);

                    $pending_code->code = $asyncDataRFB->code;
                    $pending_code->status = 'Pendiente';
                    $pending_code->save();
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Codigo generado: ' . $pending_code->code);

                    $espera = ($wait * 60) + $wait_scnds;
                } catch (Exception $e) {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Error al ejecutar la busqueda en facebook para generar el codigo');
                    Storage::append($fileName, $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
                }
            }
            $texto_success = '[' . date('Y-m-d H:i:s') . "]:Generación de codigos pendientes finalizada\n";
            Storage::append($fileName, $texto_success);
        }
        //$texto_success = "[" . date("Y-m-d H:i:s") . "]: No hay codigos de facebook pendientes\n";
            //Storage::append($fileName,$texto_success);
    }
}
