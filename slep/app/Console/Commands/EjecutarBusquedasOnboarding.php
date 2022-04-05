<?php

namespace App\Console\Commands;

use App\Models\Campania;
use App\Models\OnboardingBusqueda;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class EjecutarBusquedasOnboarding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Ejecutar_Busquedas_Onboarding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecutar busquedas pendientes en tabla onboarding';

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
        $ob_arr = OnboardingBusqueda::where('estado', 'No ejecutada')->get();

        $fileName = date('Y-m-d') . ' Busquedas Onboarding.txt';

        if (count($ob_arr) > 0) {
            /*
                Para enviar un correo HTML, debe establecerse la cabecera Content-type
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                // Cabeceras adicionales
                $cabeceras .= 'From: Birs <sergio.aslacker@gmail.com>' . "\r\n";
            */
            $texto = '[' . date('Y-m-d H:i:s') . ']: Ejecucion Iniciada ';
            Storage::append($fileName, $texto);

            foreach ($ob_arr as $ob) {
                Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Ejecutando ' . $ob->id . ': ' . $ob->nombre_busqueda . '...');

                $request_new_busqueda = new Request();
                $request_new_busqueda->palabraClave = $ob->palabra_busqueda;
                $request_new_busqueda->nombreBusqueda = $ob->nombre_busqueda;
                $request_new_busqueda->fecha1 = $ob->fecha_inicial;
                $request_new_busqueda->fecha2 = $ob->fecha_final;
                $request_new_busqueda->campañas_select = [$ob->campania_id];
                $request_new_busqueda->user_id_on = $ob->user_id;

                try {
                    $funcion = $controller->losTweets($request_new_busqueda);
                    $ob->estado = 'Ejecutada';
                    $ob->save();
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Ejecución Exitosa');
                    //Si terminaron las 3 busuqedas del usuario asociado se debe enviar un correo
                    $c = Campania::where('id', $ob->campania_id)->first();
                    $busquedas = $c->busquedas;
                    if (count($busquedas) == 3) {
                        $usr = User::where('id', $ob->user_id)->first();
                        Storage::append($fileName, '[' . date('Y-m-d H:i:s') . "]: Las 3 busquedas han finalizado\nEnviando informe a: " . $usr->email . '...');

                        try {
                            $url_base = env('APP_URL');
                            $url_informe = $url_base . '/informe/c' . $c->id;
                            /*
                                                        $from = "sergio.aslacker@gmail.com";
                                                        $to = $usr->email;
                                                        $subject = "Su primer informe lector ha sido generado";
                                                        $message = "Acceder al informe lector: ".$url_informe;
                                                        $headers = "From:" . $from;
                                                        mail($to,$subject,$message, $headers);
                            */
                            /*
                                $para = $usr->email;
                                $título = 'Su primer informe lector ha sido generado';
                                $mensaje = '
                                <html xmlns="http://www.w3.org/1999/xhtml"> <head> <meta name="viewport" content="width=device-width, initial-scale=1.0" /> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> <meta name="color-scheme" content="light"> <meta name="supported-color-schemes" content="light"> <style> @media only screen and (max-width:600px){.inner-body{width:100% !important;}.footer{width:100% !important;}}@media only screen and (max-width:500px){.button{width:100% !important;}} </style> <style> body,body *:not(html):not(style):not(br):not(tr):not(code){box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";position:relative;}body{-webkit-text-size-adjust:none;background-color:#ffffff;color:#718096;height:100%;line-height:1.4;margin:0;padding:0;width:100% !important;}p,ul,ol,blockquote{line-height:1.4;text-align:left;}a{color:#3869d4;}a img{border:none;}h1{color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left;}h2{font-size:16px;font-weight:bold;margin-top:0;text-align:left;}h3{font-size:14px;font-weight:bold;margin-top:0;text-align:left;}p{font-size:16px;line-height:1.5em;margin-top:0;text-align:left;}p.sub{font-size:12px;}img{max-width:100%;}.wrapper{-premailer-cellpadding:0;-premailer-cellspacing:0;-premailer-width:100%;background-color:#edf2f7;margin:0;padding:0;width:100%;}.content{-premailer-cellpadding:0;-premailer-cellspacing:0;-premailer-width:100%;margin:0;padding:0;width:100%;}.header{padding:25px 0;text-align:center;}.header a{color:#3d4852;font-size:19px;font-weight:bold;text-decoration:none;}.logo{height:75px;max-height:75px;width:75px;}.body{-premailer-cellpadding:0;-premailer-cellspacing:0;-premailer-width:100%;background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%;}.inner-body{-premailer-cellpadding:0;-premailer-cellspacing:0;-premailer-width:570px;background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;box-shadow:0 2px 0 rgba(0,0,150,0.025),2px 4px 0 rgba(0,0,150,0.015);margin:0 auto;padding:0;width:570px;}.subcopy{border-top:1px solid #e8e5ef;margin-top:25px;padding-top:25px;}.subcopy p{font-size:14px;}.footer{-premailer-cellpadding:0;-premailer-cellspacing:0;-premailer-width:570px;margin:0 auto;padding:0;text-align:center;width:570px;}.footer p{color:#b0adc5;font-size:12px;text-align:center;}.footer a{color:#b0adc5;text-decoration:underline;}.table table{-premailer-cellpadding:0;-premailer-cellspacing:0;-premailer-width:100%;margin:30px auto;width:100%;}.table th{border-bottom:1px solid #edeff2;margin:0;padding-bottom:8px;}.table td{color:#74787e;font-size:15px;line-height:18px;margin:0;padding:10px 0;}.content-cell{max-width:100vw;padding:32px;}.action{-premailer-cellpadding:0;-premailer-cellspacing:0;-premailer-width:100%;margin:30px auto;padding:0;text-align:center;width:100%;}.button{-webkit-text-size-adjust:none;border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;}.button-blue,.button-primary{background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748;}.button-green,.button-success{background-color:#48bb78;border-bottom:8px solid #48bb78;border-left:18px solid #48bb78;border-right:18px solid #48bb78;border-top:8px solid #48bb78;}.button-red,.button-error{background-color:#e53e3e;border-bottom:8px solid #e53e3e;border-left:18px solid #e53e3e;border-right:18px solid #e53e3e;border-top:8px solid #e53e3e;}.panel{border-left:#2d3748 solid 4px;margin:21px 0;}.panel-content{background-color:#edf2f7;color:#718096;padding:16px;}.panel-content p{color:#718096;}.panel-item{padding:0;}.panel-item p:last-of-type{margin-bottom:0;padding-bottom:0;}.break-all{word-break:break-all;} .ii a[href] { color: #fff; } </style> </head> <body> <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td align="center"> <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td class="header"> <a href="'. $url_base. '" style="display: inline-block;"> <img src="https://birs-dev.thatcloud.io/assets/img/avatars/birs_profile.png" class="logo" alt="Birs Logo"> </a> </td> </tr> <!-- Email Body --> <tr> <td class="body" width="100%" cellpadding="0" cellspacing="0"> <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation"> <!-- Body content --> <tr> <td class="content-cell"> <h1>Su informe lector ha sido generado</h1> <p>Puede consultarlo en el siguiente botón</p> <!--br> <p>Linea de prueba 2, despues vienen dos br</p> <br><br> <p>Linea de prueba 3, despues no vienen br</p--> <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td align="center"> <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td align="center"> <table border="0" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td> <a href="'. $url_informe. '" class="button button-primary" target="_blank" rel="noopener" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748">Ir a Informe Lector</a> </td> </tr> </table> </td> </tr> </table> </td> </tr> </table> <table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td> <!--table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td class="panel-content"> <table width="100%" cellpadding="0" cellspacing="0" role="presentation"> <tr> <td class="panel-item"> asasaas </td> </tr> </table> </td> </tr> </table--> </td> </tr> </table> </td> </tr> </table> </td> </tr> <!--div>FOOTER</div--> </table> </td> </tr> </table> </body> </html>
                                ';
                                mail($para, $título, $mensaje, $cabeceras);
                            */
                            $email_informe = Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => env('SENDGRID_API_KEY')])
                                ->withBody('{"personalizations":[{"to":[{"email":"' . $usr->email . '"}],"dynamic_template_data":{"nombre":"' . $usr->name . '","url":"' . $url_informe . '","mensaje":"TU INFORME LECTOR HA SIDO GENERADO"}}],"from":{"email":"soporte@birs.ai"},"subject":"Tu Informe Lector ha sido generado!","content":[{"type":"text/html","value":"Heya!"}],"template_id":"d-7027eb50b06a4188993702083dd2e656"}', 'text/plain')
                                ->post('https://api.sendgrid.com/v3/mail/send');
                            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Informe Enviado');
                        } catch (Exception $e) {
                            Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Error al enviar informe');
                            Storage::append($fileName, $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
                        }
                    }
                } catch (Exception $e) {
                    $ob->estado = 'Error';
                    $ob->save();
                    Storage::append($fileName, '[' . date('Y-m-d H:i:s') . ']: Error al ejecutar la busqueda');
                    Storage::append($fileName, $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile() . "\n");
                }
            }
            $texto_success = '[' . date('Y-m-d H:i:s') . "]: Ejecucion de Busquedas finalizada\n";
            Storage::append($fileName, $texto_success);
        }
        //$texto_success = "[" . date("Y-m-d H:i:s") . "]: No hay busquedas pendientes\n";
            //Storage::append($fileName,$texto_success);
    }
}
