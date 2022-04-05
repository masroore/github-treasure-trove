<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\Inversion;
use App\Models\OrdenPurchases;
use App\Models\Packages;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Throwable;

class TiendaController extends Controller
{
    public $apis_key_nowpayments;

    public $inversionController;

    public $walletController;

    public function __construct()
    {
        $this->walletController = new WalletController();
        $this->inversionController = new InversionController();
        $this->apis_key_nowpayments = 'DFR7W73-93J4GW1-M1XE745-M8RPDVD';
    }

    /**
     * Lleva a la vista de la tienda.
     */
    public function index()
    {
        try {
            // title
            $packages = Packages::orderBy('id', 'desc')->paginate();

            $invertido = Auth::user()->inversionMasAlta();
            // dd($invertido);
            if (isset($invertido)) {
                $invertido = $invertido->invertido;
            }

            return view('shop.index', compact('packages', 'invertido'));
        } catch (Throwable $th) {
            Log::error('Tienda - Index -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    // /**
    //  * Lleva a la vista de productos de un paquete en especificio
    //  *
    //  * @param integer $idgroup
    //  * @return void
    //  */
    // public function products($idgroup)
    // {
    //     try {
    //         // title
    //         //YA NO VA ERA DE HDLR
    //         $category = Groups::find($idgroup);
    //         $services = $category->getPackage->where('status', 1);

    //         return view('shop.products', compact('services'));
    //     } catch (\Throwable $th) {
    //         Log::error('Tienda - products -> Error: '.$th);
    //         abort(403, "Ocurrio un error, contacte con el administrador");
    //     }
    // }

    /**
     * Permiete procesar la orden de compra.
     */
    public function procesarOrden(Request $request)
    {
        $validate = $request->validate([
            'idproduct' => 'required',
        ]);

        //try {
        if ($validate) {
            $paquete = Packages::find($request->idproduct);

            if (isset(Auth::user()->inversionMasAlta()->invertido)) {
                $inversion = Auth::user()->inversionMasAlta();
                $pagado = $inversion->invertido;

                $nuevoInvertido = ($paquete->price - $pagado);
                $porcentaje = ($nuevoInvertido * 0.03);

                $total = ($nuevoInvertido + $porcentaje);
                //ACTUALIZAMOS LA INVERSION
                /*
                $inversion->invertido += $nuevoInvertido;
                $inversion->capital += $nuevoInvertido;
                $inversion->max_ganancia = $inversion->invertido * 2;
                $inversion->restante += $nuevoInvertido * 2;
                $inversion->save();
                */
                $data = [
                    'iduser' => Auth::id(),
                    'package_id' => $paquete->id,
                    'cantidad' => 1,
                    'total' => $total,
                    'monto' => $nuevoInvertido,
                ];

                //$orden = OrdenPurchases::findOrFail($inversion->orden_id)->update($data);
                $data['idorden'] = $this->saveOrden($data);
                $data['descripcion'] = 'Upgrade al paquete ' . $paquete->name;
            //$data['inversion_id'] = $inversion->id;
            } else {
                $porcentaje = 0; //($paquete->price * 0.03);

                $total = ($paquete->price + $porcentaje);
                $data = [
                    'iduser' => Auth::id(),
                    'package_id' => $paquete->id,
                    'cantidad' => 1,
                    'total' => $total,
                    'monto' => $paquete->price,
                ];

                $data['idorden'] = $this->saveOrden($data);
                $data['descripcion'] = $paquete->description;
            }

            $cmd = 'create_transaction';
            $email = User::find(Auth::id())->email;
            $dataPago = [
                'amount' => $data['total'],
                'currency1' => 'USDT.TRC20',
                'currency2' => 'USDT.TRC20',
                'buyer_email' => $email,

            ];
            $url = $this->coinpayments_api_call($cmd, $dataPago);
            // dd($url);
            if (!empty($url)) {
                $orden = OrdenPurchases::where('id', $data['idorden'])->first();
                $orden->update(['idtransacion' => $url['result']['txn_id']]);

                return redirect($url['result']['checkout_url']);
            }

            OrdenPurchases::where('id', $data['idorden'])->delete();

            return redirect()->back()->with('msj-info', 'Problemas al general la orden, intente mas tarde');
        }
        /*} catch (\Throwable $th) {
            Log::error('Tienda - procesarOrden -> Error: '.$th);
            abort(403, "Ocurrio un error (1) , contacte con el administrador");
        }*/
    }

    /**
     * Guarda la informacion de las ordenes nuevas.
     *
     * @param array $data
     *
     * @return int
     */
    public function saveOrden($data)
    {
        $orden = OrdenPurchases::create($data);
        $patrocinador = $orden->getOrdenUser->referred_id;
        $side = $orden->getOrdenUser->binary_side;
        if ($side == 'I') {
            User::where([
                ['id', '=', $patrocinador],
                ['not_payment_binary_point_izq', '=', 0],
            ])->update(['not_payment_binary_point_izq' => $orden->id]);
        } else {
            User::where([
                ['id', '=', $patrocinador],
                ['not_payment_binary_point_der', '=', 0],
            ])->update(['not_payment_binary_point_der' => $orden->id]);
        }

        return $orden->id;
    }

    /**
     * Notifica el estado de la compra una vez realizada.
     *
     * @param string $status
     */
    public function statusProcess($status)
    {
        $type = ($status == 'Completada') ? 'success' : 'danger';
        $msj = 'Compra ' . $status;

        return redirect()->route('shop')->with('msj-' . $type, $msj);
    }

    /**
     * Permite recibir el estado de las ordenes.
     */
    public function ipn(Request $resquet): void
    {
        Log::info('ipn prueba ->', $resquet);
    }

    /**
     * Permite general el url para pagar la compra.
     *
     * @return string
     */
    // private function generalUrlOrden($data): string
    // {
    //     try {
    //         $this->apis_key_nowpayments = Crypt::decryptString("eyJpdiI6IkRLT2tDbFJ1ZTJnWUVCSEs2VkZMaVE9PSIsInZhbHVlIjoiTkVuaXpGQ1EvSWlkcnU1djI2N0tnK08yc0w2TVpQdkZrOFlKNTF5YzNTcz0iLCJtYWMiOiI0Y2M2NzI5NDQzMjM3ODI2ZTg3YjMyYTRhZWU4ODM5NTYxYmE2ZTIyMzIxNmI3MmNhYTQ1NDQ5ZGVlZGFhYjdlIn0=");
    //         $headers = [
    //             'x-api-key: '.$this->apis_key_nowpayments,
    //             'Content-Type:application/json'
    //         ];
    //         $resul = '';
    //         $curl = curl_init();

    //         $dataRaw = collect([
    //             'price_amount' => floatval($data['total'])  ,
    //             "price_currency" => "usd",
    //             "order_id" => $data['idorden'],
    //             'pay_currency' => '',
    //             "order_description" => $data['descripcion'],
    //             "ipn_callback_url" => route('shop.ipn'),
    //             "success_url" => route('shop.proceso.status', 'Completada'),
    //             "cancel_url" => route('shop.proceso.status', 'Cancelada')
    //         ]);

    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => "https://api.nowpayments.io/v1/invoice",
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 30,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "POST",
    //             CURLOPT_POSTFIELDS => $dataRaw->toJson(),
    //             CURLOPT_HTTPHEADER => $headers
    //         ));

    //             $response = curl_exec($curl);
    //             $err = curl_error($curl);
    //           //  dd($dataRaw);

    //             curl_close($curl);
    //             if ($err) {
    //                 Log::error('Tienda - generalUrlOrden -> Error curl: '.$err);
    //             } else {
    //                 $response = json_decode($response);
    //                 // dd($response);

    //                 $orden = OrdenPurchases::where('id', $data['idorden'])->first();

    //                 $orden->update(['idtransacion' => $response->id]);

    //                 $resul = $response->invoice_url;
    //             }

    //         return $resul;
    //     } catch (\Throwable $th) {
    //         Log::error('Tienda - generalUrlOrden -> Error: '.$th);
    //         abort(403, "Ocurrio un error, contacte con el administrador");
    //     }
    // }
    /**
     * Funcion que hace el llamado a la api de coinpayment
     * 	ojo: esto dejarlo tal cual, en coinpayment debe permitir este procedimiento "create_withdrawal".
     *
     * @param string $cmd - transacion a ejecutar
     * @param array $req - arreglo con el request a procesar
     */
    public function coinpayments_api_call($cmd, $req = [])
    {
        // Fill these in from your API Keys page
        $public_key = Crypt::decryptString('eyJpdiI6IlljeE1EVkJYY0twWVZiWHRTRXhSU2c9PSIsInZhbHVlIjoiTGtoZ2tKekgzZHdEdTlqN01VdWxyd3J4a0JkanNScjJyT1FFYnlIZ3M1TUN0ZDRYM2ppWkFGbis3QXRwUUlrSmNNd0o2V3RBOUhaZEJPKytXU0hvb01JWXZYNFNsK2NWbmhmSHNLU25tNzQ9IiwibWFjIjoiZDY3MjcwODBlYWRjZWJhMmQzYzIzNWViNGJiNjNjNDQ5YWNhNzRjNDljZWMwNjk5NTM2MzZiY2RjY2ZkMThkZiJ9');
        $private_key = Crypt::decryptString('eyJpdiI6ImcrcWRTcUd6dFdORHJibElabDJDTXc9PSIsInZhbHVlIjoiOXBwRDRWNGp3aEthK005T1pRbEVCVlYwTlBDWnUrcU1jdmFpQWYvVytnNWtWWStiQkdUY2lnSjRNTEluSm9ic1JFZXdUVisyTWpqSEpqWnR0Q0tUREhManRWRXVVTWt2L2IrL0ZrUTVOb0E9IiwibWFjIjoiNjUyMmIzY2Q0YjQyZDQxZTdhZDUyOGVhNGY4YmU5ZWNlNDhlZDg5YTFmOGU4YzU4ZDczOWI2MWY3YjM5YWRmNiJ9');
        // Set the API command and required fields
        $req['version'] = 1;
        $req['cmd'] = $cmd;
        $req['key'] = $public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $private_key);

        // Create cURL handle and initialize (if needed)
        static $ch = null;
        if ($ch === null) {
            $ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['HMAC: ' . $hmac]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        // Execute the call and close cURL handle
        $data = curl_exec($ch);

        // Parse and return data if successful.
        if ($data !== false) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data, true);
            }
            if ($dec !== null && count($dec)) {
                return $dec;
            }
            // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
            return ['error' => 'Unable to parse JSON result (' . json_last_error() . ')'];
        }

        return ['error' => 'cURL error: ' . curl_error($ch)];
    }

    public function cambiar_status(Request $request)
    {
        $orden = OrdenPurchases::findOrFail($request->id);
        $orden->status = $request->status;
        $orden->save();
        $user = User::findOrFail($orden->iduser);

        $this->walletController->payAll();

        if (isset($user->inversionMasAlta()->invertido)) {
            $inversion = $user->inversionMasAlta();
            $pagado = $inversion->invertido;

            $nuevoInvertido = ($orden->getPackageOrden->price - $pagado);
            $porcentaje = ($nuevoInvertido * 0.03);

            $total = ($nuevoInvertido + $porcentaje);
            //ACTUALIZAMOS LA INVERSION
            $inversion->invertido += $nuevoInvertido;
            $inversion->capital += $nuevoInvertido;
            if (isset($inversion->max_ganancia, $inversion->invertido)) {
                $inversion->max_ganancia = $inversion->invertido * 2;
                $inversion->restante += $nuevoInvertido * 2;
            }
            $inversion->package_id = $orden->package_id;
            $inversion->save();
            $inversion = $inversion->id;
        } else {
            $inversion = $this->registeInversion($request->id);
        }

        $orden->inversion_id = $inversion;
        $orden->save();

        $user = User::findOrFail($orden->iduser);
        $user->status = '1';
        $user->save();

        return redirect()->back()->with('msj-success', 'Orden actualizada exitosamente');
    }

    private function registeInversion($idorden)
    {
        $orden = OrdenPurchases::find($idorden);
        if ($orden != null) {
            $paquete = $orden->getPackageOrden;
            $total = $orden->cantidad * $paquete->price;

            //dd([$paquete->id, $orden->id, $orden->cantidad, $paquete->expired, $orden->iduser]);
            return $this->inversionController->saveInversion($paquete->id, $total, $paquete->expired, $orden->iduser);
        }
    }

    /**
     * Permite saber el estado de las ordenes realizadas.
     */
    public function checkStatusOrden(): void
    {
        $this->apis_key_nowpayments = Crypt::decryptString('eyJpdiI6IkRLT2tDbFJ1ZTJnWUVCSEs2VkZMaVE9PSIsInZhbHVlIjoiTkVuaXpGQ1EvSWlkcnU1djI2N0tnK08yc0w2TVpQdkZrOFlKNTF5YzNTcz0iLCJtYWMiOiI0Y2M2NzI5NDQzMjM3ODI2ZTg3YjMyYTRhZWU4ODM5NTYxYmE2ZTIyMzIxNmI3MmNhYTQ1NDQ5ZGVlZGFhYjdlIn0=');
        $headers = [
            'x-api-key: ' . $this->apis_key_nowpayments,
            'Content-Type:application/json',
        ];

        $resul = '';
        $curl = curl_init();

        $fechaTo = Carbon::now();
        $fechaFrom = $fechaTo->copy()->subDays(2);

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.nowpayments.io/v1/payment?limit=100&dateFrom=' . $fechaFrom->format('Y-m-d') . '&dateTo=' . $fechaTo->copy()->addDays(1)->format('Y-m-d'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            Log::error('Tienda - checkStatusOrden -> Error curl: ' . $err);
        } else {
            $response = json_decode($response);
            $pagos = $response->data;
            // dd($pagos);
            foreach ($pagos as $pago) {
                // if ($pago->order_id < 964 && $pago->order_id > 968) {
                $estado = '0';
                if ($pago->payment_status == 'expired') {
                    $estado = '2';
                    OrdenPurchases::where('id', '=', $pago->order_id)->update(['status' => $estado]);
                }
                if ($pago->payment_status == 'finished') {
                    $estado = '1';
                    OrdenPurchases::where('id', '=', $pago->order_id)->update(['status' => $estado]);
                }
                if ($pago->payment_status == 'partially_paid') {
                    $resta = ($pago->pay_amount - $pago->actually_paid);
                    if ($resta <= 1) {
                        $estado = '1';
                        OrdenPurchases::where('id', '=', $pago->order_id)->update(['status' => $estado]);
                    }
                }
                if ($estado == '1') {
                    $orden = OrdenPurchases::find($pago->order_id);
                    $patrocinador = $orden->getOrdenUser->referred_id;
                    $side = $orden->getOrdenUser->binary_side;
                    if ($side == 'I') {
                        User::where([
                            ['id', '=', $patrocinador],
                            ['not_payment_binary_point_izq', '=', 0],
                        ])->update(['not_payment_binary_point_izq' => $orden->id]);
                    } else {
                        User::where([
                            ['id', '=', $patrocinador],
                            ['not_payment_binary_point_der', '=', 0],
                        ])->update(['not_payment_binary_point_der' => $orden->id]);
                    }
                    $this->registeInversion($pago->order_id);
                }
                Log::info('ID Orden: ' . $pago->order_id . ' - Transacion: ' . $pago->invoice_id . ' Estado: ' . $pago->payment_status);
                // }
            }
            // $resul = $response->invoice_url;
        }
    }

    /**
     * Activa los usuario cuando apenas compre.
     */
    public function activarUser(): void
    {
        try {
            $ordenes = Inversion::where('status', '!=', '1')->whereDate('created_at', '>', Carbon::now()->subMonths(6))->get();
            foreach ($ordenes as $orden) {
                $orden->getInversionesUser->update(['status' => '0']);
            }

            $ordenes = Inversion::where('status', '1')->whereDate('created_at', '>', Carbon::now()->subMonths(6))->get();
            foreach ($ordenes as $orden) {
                $orden->getInversionesUser->update(['status' => '1']);
            }

            Log::info('Inicio de los puntos y comisiones diarias - ' . Carbon::now());
            $this->walletController->payAll();
            Log::info('Fin de los puntos y comisiones diarias - ' . Carbon::now());
        } catch (Throwable $th) {
            Log::error('ActivacionController - activarUser -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite verificar las compras por el id de la misma.
     *
     * @param [type] $idcompra
     */
    public function checkUserPurchaseForID($idcompra): void
    {
        // $this->registeInversion(882);
        // $this->registeInversion(965);
        // $this->registeInversion(967);
        // $this->registeInversion(968);
        // $this->activarUser();
        // $this->apis_key_nowpayments = Crypt::decryptString("eyJpdiI6IkRLT2tDbFJ1ZTJnWUVCSEs2VkZMaVE9PSIsInZhbHVlIjoiTkVuaXpGQ1EvSWlkcnU1djI2N0tnK08yc0w2TVpQdkZrOFlKNTF5YzNTcz0iLCJtYWMiOiI0Y2M2NzI5NDQzMjM3ODI2ZTg3YjMyYTRhZWU4ODM5NTYxYmE2ZTIyMzIxNmI3MmNhYTQ1NDQ5ZGVlZGFhYjdlIn0=");
        // $headers = [
        //     'x-api-key: '.$this->apis_key_nowpayments,
        //     'Content-Type:application/json'
        // ];

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.nowpayments.io/v1/payment/?limit=500&page=1",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => $headers
        // ));

        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        // if ($err) {
        //     Log::error('Tienda - checkStatusOrden -> Error curl: '.$err);
        // } else {
        //     $response = json_decode($response);
        //     if (!empty($response->data)) {
        //         $pagos = $response->data;
        //         foreach ($pagos as $pago) {
        //             $orden = OrdenPurchases::find($pago->order_id);
        //             if (!empty($orden)) {
        //                 if ($orden->iduser == 28 || $orden->iduser == 333 || $orden->iduser == 570 || $orden->iduser == 673 || $orden->iduser == 689 || $orden->iduser == 690 || $orden->iduser == 703 || $orden->iduser == 288 || $orden->iduser == 473 || $orden->iduser == 695 || $orden->iduser == 765 || $orden->iduser == 241) {
        //                     $estado = '0';
        //                     if ($pago->payment_status == 'expired') {
        //                         $estado = '2';
        //                         OrdenPurchases::where('id', '=', $pago->order_id)->update(['status' => $estado]);
        //                     }
        //                     if($pago->payment_status == 'finished'){
        //                         $estado = '1';
        //                         OrdenPurchases::where('id', '=', $pago->order_id)->update(['status' => $estado]);
        //                     }
        //                     if($pago->payment_status == 'partially_paid'){
        //                         $resta = ($pago->pay_amount - $pago->actually_paid);
        //                         if ($resta <= 1) {
        //                             $estado = '1';
        //                             OrdenPurchases::where('id', '=', $pago->order_id)->update(['status' => $estado]);
        //                         }
        //                     }
        //                     if ($estado == '1') {
        //                         $this->registeInversion($pago->order_id);
        //                     }
        //                     dump('ID Orden: '.$pago->order_id.' - Transacion: '.$pago->invoice_id.' Estado: '.$pago->payment_status);
        //                     Log::info('ID Orden: '.$pago->order_id.' - Transacion: '.$pago->invoice_id.' Estado: '.$pago->payment_status);
        //                 }
        //             }
        //         }
        //     }
        //     // $resul = $response->invoice_url;
        // }
    }
}
