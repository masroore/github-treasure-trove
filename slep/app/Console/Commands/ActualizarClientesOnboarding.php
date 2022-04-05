<?php

namespace App\Console\Commands;

use App\Models\Busqueda;
use App\Models\Campania;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use stdClass;

class ActualizarClientesOnboarding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Actualizar_Clientes_Onboarding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualización de las busquedas de los clientes con rol Guest';

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
        //$guest_users_x_busquedas=[];
        $guest_users_x_campañas = [];

        $users = User::all();
        foreach ($users as $user) {
            if ($user->getRoleNames()->first() == 'guest') {
                $current_element = new stdClass();
                $current_element->uid = $user->id;
                $current_element->uname = $user->name;
                $current_element->uemail = $user->email;

                //$uid_busquedas = Busqueda::where('user_id',$user->id)->get();
                //$current_element->bids = $uid_busquedas;
                //array_push($guest_users_x_busquedas, $current_element);

                $uid_campañas = Campania::where('user_id', $user->id)->get();
                $current_element->ucampanias = $uid_campañas;
                $guest_users_x_campañas[] = $current_element;
            }
        }
        $fileName = date('Y-m-d') . ' Actualizaciones de Clientes Onboarding.txt';
        $texto = '[' . date('Y-m-d H:i:s') . ']: Actualizacion iniciada ';
        Storage::append($fileName, $texto);

        try {
            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Evaluando campañas de usuarios con rol Guest');
            foreach ($guest_users_x_campañas as $g_usr) {
                $id_campania_email = '';
                if (count($g_usr->ucampanias) != 0) {
                    Storage::append($fileName, "\nUsuario " . $g_usr->uid . "\n");
                    foreach ($g_usr->ucampanias as $c) {
                        if (count($c->busquedas) != 0) {
                            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: La campaña ' . $c->id . " tiene busquedas\n");
                            foreach ($c->busquedas as $b) {
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
                                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Búsqueda ' . $b->id . " Actualizada\n");
                                } catch (Exception $e) {
                                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: ERROR: Búsqueda ' . $b->id . ' No Actualizada');
                                    Storage::append($fileName, $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
                                }
                            }
                            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Las busquedas de la campaña ' . $c->id . " han finalizado\nEnviando informe a: " . $g_usr->uemail . '...');

                            try {
                                $url_base = env('APP_URL');
                                $url_informe = $url_base . '/informe/c' . $c->id;
                                $email_informe = Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => env('SENDGRID_API_KEY')])
                                    ->withBody('{"personalizations":[{"to":[{"email":"' . $g_usr->uemail . '"}],"dynamic_template_data":{"nombre":"' . $g_usr->uname . '","url":"' . $url_informe . '","mensaje":"TU INFORME LECTOR HA SIDO ACTUALIZADO"}}],"from":{"email":"soporte@birs.ai"},"subject":"Tu Informe Lector ha sido actualizado!","content":[{"type":"text/html","value":"Heya!"}],"template_id":"d-7027eb50b06a4188993702083dd2e656"}', 'text/plain')
                                    ->post('https://api.sendgrid.com/v3/mail/send');
                                Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Informe Enviado');
                            } catch (Exception $e) {
                                Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Error al enviar informe');
                                Storage::append($fileName, $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
                            }
                        } else {
                            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: La campaña ' . $c->id . " no tiene busquedas\n");
                        }
                    }
                } else {
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: El usuario ' . $g_usr->uid . " no tiene campañas\n");
                }
            }
            $texto_success = '[' . date('Y-m-d H:i:s') . "]: Actualización finalizada\n";
            Storage::append($fileName, $texto_success);
        } catch (Exception $e) {
            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Error al actualizar busquedas de clientes');
            Storage::append($fileName, $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
        }
    }
}
