<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;

class ConsultarResultadosFacebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Consultar_Resultados_Facebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preguntar cada cierto tiempo si los codigos tienen resultados y obtenerlos si es asi';

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
        $toast_pendiente = 'toastr["success"]("Etiqueta agregada al resultado")';

        $controller = resolve('App\Http\Controllers\AsyncSourcesController');
        $all_async_results = $controller->getAllAsyncResultsSys();

        $fileName = date('Y-m-d') . ' Resultados Asíncronos.txt';
        $texto = '[' . date('Y-m-d H:i:s') . ']: Consulta Resultados Pendientes';
        Storage::append($fileName, $texto);

        foreach ($all_async_results as $async_r) {
            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Consulta estado del código |' . $async_r->code . '|ID: ' . $async_r->id . '|...');

            try {
                $status = $controller->facebookCheckStatus($async_r->code);
                if ($status['status'] == 201) {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ' . $status['status'] . ' | Pendiente' . "\n");
                //echo('<script type="text/javascript">'.$toast_pendiente.'</script>');
                } elseif ($status['status'] == 200) {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ' . $status['status'] . ' | Finalizado, Obteniendo resultados...');
                    $resultados = $controller->facebookGetResults($async_r->code);
                    Storage::append($fileName, $resultados . "\n");
                } elseif ($status['status'] == 404) {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ' . $status['status'] . ' | Error, no es posible traer resultados..');
                    $resultados = $controller->facebookGetResults($async_r->code);
                    Storage::append($fileName, $resultados . "\n");
                } else {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ' . $status['status'] . ' | <- Respuesta recibida' . "\n");
                }
            } catch (Exception $e) {
                Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ERROR DE CONSULTA');
                Storage::append($fileName, 'Linea ' . $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
            }
        }
        Storage::append($fileName, '[' . date('Y-m-d H:i:s') . "]: Consulta de Resultados Pendientes Finalizada\n");
        //return 0;
    }
}
