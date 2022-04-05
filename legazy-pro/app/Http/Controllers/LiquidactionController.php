<?php

namespace App\Http\Controllers;

use App\Models\Liquidaction;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class LiquidactionController extends Controller
{
    public $walletController;

    public $doubleAuthController;

    public function __construct()
    {
        $this->walletController = new WalletController();
        $this->doubleAuthController = new DoubleAutenticationController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $liquidation = Liquidaction::where([
                ['iduser', '=', Auth::id()],
                ['status', '=', 0],
            ])->first();
            if ($liquidation != null) {
                if (!session()->has('intentos_fallidos')) {
                    session(['intentos_fallidos' => 0]);
                }
            }
            $comisiones = $this->getTotalComisiones([], Auth::id());

            return view('settlement.index', compact('comisiones', 'liquidation'));
        } catch (Throwable $th) {
            Log::error('Liquidaction - index -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPendientes()
    {
        try {
            $liquidaciones = Liquidaction::where('status', 0)->get();
            foreach ($liquidaciones as $liqui) {
                $liqui->fullname = $liqui->getUserLiquidation->fullname;
            }

            return view('settlement.pending', compact('liquidaciones'));
        } catch (Throwable $th) {
            Log::error('Liquidaction - indexPendientes -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * LLeva a la vistas de las liquidaciones reservadas o aprobadas.
     *
     * @param string $status
     */
    public function indexHistory($status)
    {
        try {
            $estado = ($status == 'Reservadas') ? 2 : 1;
            $liquidaciones = Liquidaction::where('status', $estado)->get();
            foreach ($liquidaciones as $liqui) {
                $liqui->fullname = $liqui->getUserLiquidation->fullname;
            }

            return view('settlement.history', compact('liquidaciones', 'estado'));
        } catch (Throwable $th) {
            Log::error('Liquidaction - indexHistory -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->tipo == 'detallada') {
            $validate = $request->validate([
                'listComisiones' => ['required', 'array'],
                'iduser' => ['required'],
            ]);
        } else {
            $validate = $request->validate([
                'listUsers' => ['required', 'array'],
            ]);
        }

        try {
            if ($validate) {
                $mensaje = 'Liquidaciones Generada Exitoxamente';
                $tipo = 'msj-success';
                $msj = 0;
                if ($request->tipo == 'detallada') {
                    $msj = $this->generarLiquidation($request->iduser, $request->listComisiones);
                } else {
                    foreach ($request->listUsers as $iduser) {
                        $msj = $this->generarLiquidation($iduser, []);
                    }
                }
                if ($msj == 0) {
                    $mensaje = 'El monto a retirar esta por debajo del limite permitido que es 50$';
                    $tipo = 'msj-warning';
                }

                return redirect()->back()->with($tipo, $mensaje);
            }
        } catch (Throwable $th) {
            Log::error('Liquidaction - store -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $comiciones = Wallet::where([
                ['status', '=', 0],
                ['liquidation_id', '=', null],
                ['tipo_transaction', '=', 0],
                ['iduser', '=', $id],
            ])->get();

            foreach ($comiciones as $comi) {
                $fecha = new Carbon($comi->created_at);
                $comi->fecha = $fecha->format('Y-m-d');
                $referido = User::find($comi->referred_id);
                $comi->referido = ($referido != null) ? $referido->only('fullname') : 'Usuario no Disponible';
            }

            $user = User::find($id);

            $detalles = [
                'iduser' => $id,
                'fullname' => $user->fullname,
                'comisiones' => $comiciones,
                'total' => number_format($comiciones->sum('monto'), 2, ',', '.'),
            ];

            return json_encode($detalles);
        } catch (Throwable $th) {
            Log::error('Liquidaction - show -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $comiciones = Wallet::where([
                ['liquidation_id', '=', $id],
            ])->get();

            foreach ($comiciones as $comi) {
                $fecha = new Carbon($comi->created_at);
                $comi->fecha = $fecha->format('Y-m-d');
                $referido = User::find($comi->referred_id);
                $comi->referido = ($referido != null) ? $referido->only('fullname') : 'Usuario no Disponible';
            }
            $user = User::find($comiciones->pluck('iduser')[0]);

            $detalles = [
                'idliquidaction' => $id,
                'iduser' => $user->id,
                'fullname' => $user->fullname,
                'comisiones' => $comiciones,
                'total' => number_format($comiciones->sum('monto'), 2, ',', '.'),
            ];

            return json_encode($detalles);
        } catch (Throwable $th) {
            Log::error('Liquidaction - edit -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liquidaction $liquidaction)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liquidaction $liquidaction)
    {

    }

    /**
     * Permite Obtener la informacion de las comisiones y el total disponible.
     *
     * @param array $filtros - filtro para mejorar la vistas
     * @param int $iduser - si es para un usuario especifico
     */
    public function getTotalComisiones(array $filtros, ?int $iduser = null): array
    {
        try {
            $comisiones = [];
            if ($iduser != null && $iduser != 1) {
                $comisionestmp = Wallet::where([
                    ['status', '=', 0],
                    ['liquidation_id', '=', null],
                    ['tipo_transaction', '=', 0],
                    ['iduser', '=', $iduser],
                ])->select(
                    DB::raw('sum(monto) as total'),
                    'iduser'
                )->groupBy('iduser')->get();
            } else {
                $comisionestmp = Wallet::where([
                    ['status', '=', 0],
                    ['liquidation_id', '=', null],
                    ['tipo_transaction', '=', 0],
                ])->select(
                    DB::raw('sum(monto) as total'),
                    'iduser'
                )->groupBy('iduser')->get();
            }

            foreach ($comisionestmp as $comision) {
                $comision->getWalletUser;
                if ($comision->getWalletUser != null) {
                    if ($filtros == []) {
                        $comisiones[] = $comision;
                    } else {
                        if (!empty($filtros['activo'])) {
                            if ($comision->status == 1) {
                                if (!empty($filtros['mayorque'])) {
                                    if ($comision->total >= $filtros['mayorque']) {
                                        $comisiones[] = $comision;
                                    }
                                } else {
                                    $comisiones[] = $comision;
                                }
                            }
                        } else {
                            if (!empty($filtros['mayorque'])) {
                                if ($comision->total >= $filtros['mayorque']) {
                                    $comisiones[] = $comision;
                                }
                            } else {
                                $comisiones[] = $comision;
                            }
                        }
                    }
                }
            }

            return $comisiones;
        } catch (Throwable $th) {
            Log::error('Liquidaction - getTotalComisiones -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite procesar las liquidaciones.
     *
     * @param int $iduser -  id del usuario
     * @param array $listComision - comisiones a procesar si son selecionada
     */
    public function generarLiquidation(int $iduser, array $listComision): int
    {
        try {
            $user = User::find($iduser);
            $comisiones = collect();

            if ($listComision == []) {
                $comisiones = Wallet::where([
                    ['iduser', '=', $iduser],
                    ['status', '=', 0],
                    ['tipo_transaction', '=', 0],
                ])->get();
            } else {
                $comisiones = Wallet::whereIn('id', $listComision)->get();
            }

            $bruto = $comisiones->sum('monto');
            if ($bruto < 50) {
                return 0; // Esta por debajo del limite diario
            }
            $feed = ($bruto * 0.06);
            $total = ($bruto - $feed);

            $arrayLiquidation = [
                'iduser' => $iduser,
                'total' => $total,
                'monto_bruto' => $bruto,
                'feed' => $feed,
                'hash',
                'wallet_used' => $user->type_wallet . ' - ' . $user->wallet_address,
                'status' => 0,
                'code_correo' => Str::random(10),
                'fecha_code' => Carbon::now(),
            ];
            $idLiquidation = $this->saveLiquidation($arrayLiquidation);

            $dataEmail = [
                'user' => $user->fullname,
                'code' => $arrayLiquidation['code_correo'],
            ];

            Mail::send('mail.SendCodeRetiro', $dataEmail, function ($msj) use ($user): void {
                $msj->subject('Codigo Retiro');
                $msj->to($user->email);
            });

            // $concepto = 'Liquidacion del usuario '.$user->fullname.' por un monto de '.$bruto;
            // $arrayWallet =[
            //     'iduser' => $user->id,
            //     'referred_id' => $user->id,
            //     // 'credito' => $bruto,
            //     'monto' => $bruto,
            //     'descripcion' => $concepto,
            //     'status' => 0,
            //     'tipo_transaction' => 1,
            // ];

            // $this->walletController->saveWallet($arrayWallet);

            if (!empty($idLiquidation)) {
                $listComi = $comisiones->pluck('id');
                Wallet::whereIn('id', $listComi)->update([
                    'status' => 1,
                    'liquidation_id' => $idLiquidation,
                ]);
            }

            return 1; // Liquidacion exitosa
        } catch (Throwable $th) {
            Log::error('Liquidaction - generarLiquidation -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite guardar las liquidaciones y devuelve el id de la misma.
     */
    public function saveLiquidation(array $data): int
    {
        $liquidacion = Liquidaction::create($data);

        return $liquidacion->id;
    }

    /**
     * Permite elegir que opcion hacer con las liquidaciones.
     */
    public function procesarLiquidacion(Request $request)
    {
        if ($request->action == 'aproved') {
            $validate = $request->validate([
                'google_code' => ['required', 'numeric'],
                'correo_code' => ['required'],
                'wallet' => ['required'],
            ]);
        } else {
            $validate = $request->validate([
                'comentario' => ['required'],
            ]);
        }

        try {
            if ($validate) {
                $idliquidation = $request->idliquidation;
                $liquidation = Liquidaction::find($idliquidation);
                $accion = 'No Procesada';
                if ($this->reversarRetiro30Min()) {
                    return redirect()->back()->with('msj-danger', 'El tiempo limite fue excedido');
                }
                //Verifica si ha fallado mucho metiendo los codigo
                if (session()->has('intentos_fallidos')) {
                    if (session('intentos_fallidos') >= 3) {
                        session()->forget('intentos_fallidos');
                        $request->comentario = 'Demasiados Intento Fallido con los codigo';
                        $accion = 'Reversada';
                        $this->reversarLiquidacion($idliquidation, $request->comentario);
                    }

                    //Verifica si los codigo esta bien
                    if (!$this->doubleAuthController->checkCode($liquidation->iduser, $request->google_code) && $liquidation->code_correo != $request->correo_code && session()->has('intentos_fallidos')) {
                        session(['intentos_fallidos' => (session('intentos_fallidos') + 1)]);

                        return redirect()->back()->with('msj-danger', 'La Liquidacion fue ' . $accion . ' con exito, Codigos incorrectos');
                    }

                    if ($request->action == 'aproved' && session('intentos_fallidos') < 2) {
                        $aproved = $this->aprovarLiquidacion($idliquidation, $request->wallet);
                        if ($aproved == '') {
                            $accion = 'Aprobada';
                        } else {
                            $comentario = 'Error en la plataforma de coinpayment';
                            $this->reversarLiquidacion($idliquidation, $comentario);

                            return redirect()->back()->with('msj-danger', 'Hubo un error al realizar el pago. ' . $aproved);
                        }
                    }
                }

                if ($accion != 'No Procesada') {
                    $arrayLog = [
                        'idliquidation' => $idliquidation,
                        'comentario' => $request->comentario,
                        'accion' => $accion,
                    ];
                    DB::table('log_liquidations')->insert($arrayLog);
                }

                return redirect()->back()->with('msj-success', 'La Liquidacion fue ' . $accion . ' con exito');
            }
        } catch (Throwable $th) {
            Log::error('Liquidaction - saveLiquidation -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite aprobar las liquidaciones.
     *
     * @param int $idliquidation
     * @param string $billetera
     */
    public function aprovarLiquidacion($idliquidation, $billetera): string
    {
        $liquidation = Liquidaction::find($idliquidation);
        // creo el arreglo de la transacion en coipayment
        $cmd = 'create_withdrawal';
        $result2 = '';
        $dataPago = [
            'amount' => $liquidation->total,
            'currency' => 'USDT.TRC20',
            'address' => $billetera,
        ];
        // llamo la a la funcion que va a ser la transacion
        $result = $this->coinpayments_api_call($cmd, $dataPago);
        if (!empty($result['result'])) {
            Liquidaction::where('id', $idliquidation)->update([
                'status' => 1,
                'hash' => $result['result']['id'],
                'wallet_used' => $billetera,
            ]);

            Wallet::where('liquidation_id', $idliquidation)->update(['liquidado' => 1, 'status' => 1]);
        } else {
            $result2 = 'Error -> ' . $result['error'];
        }

        return $result2;
    }

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
        $public_key = Crypt::decryptString('eyJpdiI6IkpVTmpHaVlXd2FJVU85ckZ0V25TRGc9PSIsInZhbHVlIjoiTXl2WWEweGc4T1pTenJKcmdRbGZwMHdaUXNlKzczUHYwaFJLZXlNaXdrR1kvMmRtNERvaTFEa2RGZDBhNnZBa3hvNkhxYldkN3NwOUtyRG1VZG9GMEhYaVNaV0UycDR6dzZVeXR3L2pmZmM9IiwibWFjIjoiNjczNTgzYjVlMjE0YmM3OTA3YjdjYmEwOWM0NjE5OGNlMmM4MDcyNjMyNDY2MzFiODg2MzQxOThmM2I4M2U5MSJ9');
        $private_key = Crypt::decryptString('eyJpdiI6ImlKa3pIZ2UyeEdkVmJTMHg3Mm1rcXc9PSIsInZhbHVlIjoic1FNdXRldmg5UWptblFVSWRxNUdPOEFDc2xwY1NKYWU3ckpXbTlLMUphOVBtRUhnQ2h3Mnk3dUF2ellkNUJMc2tic0ZjbEhuSlF5K1ZkbEFjalR6NnF4OHVUTWxFNjlxaWIvU2YyUk9jN0E9IiwibWFjIjoiYjRjZWU3ODVjMmJhNjliZDAxYzc1MjJmMzBlMmU3MGNmNTVmYjkxMzAyMzU3YzU4Zjg4MTJlYWZhZjMyODQ4MCJ9');

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
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
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

        // dd($this->coinpayments_api_call('rates'));
    }

    /**
     * Permite procesar reversiones del sistema.
     *
     * @param int $idliquidation
     * @param string $comentario
     */
    public function reversarLiquidacion($idliquidation, $comentario): void
    {
        $liquidacion = Liquidaction::find($idliquidation);

        Wallet::where('liquidation_id', $idliquidation)->update([
            'status' => 0,
            'liquidation_id' => null,
        ]);

        // $concepto = 'Liquidacion Reservada - Motivo: '.$comentario;
        // $arrayWallet =[
        //     'iduser' => $liquidacion->iduser,
        //     'orden_purchases_id' => null,
        //     'referred_id' => $liquidacion->iduser,
        //     'monto' => $liquidacion->monto_bruto,
        //     'descripcion' => $concepto,
        //     'status' => 3,
        //     'tipo_transaction' => 0,
        // ];

        // $this->walletController->saveWallet($arrayWallet);

        $liquidacion->status = 2;
        $liquidacion->save();
    }

    /**
     * Lleva a la vista de retiros.
     */
    public function withdraw()
    {
        $this->reversarRetiro30Min();

        return view('settlement.withdraw');
    }

    /**
     * Permite generar el codigo del correo.
     *
     * @param string $wallet
     *
     * @return
     */
    public function sendCodeEmail($wallet): int
    {
        try {
            $this->reversarRetiro30Min();
            if (!session()->has('intentos_fallidos')) {
                session(['intentos_fallidos' => 1]);
            }
            $liquidation = Liquidaction::where([
                ['iduser', '=', Auth::id()],
                ['status', '=', 0],
            ])->first();
            if ($liquidation != null) {
                return $liquidation->id;
            }

            $user = Auth::user();

            $comisiones = Wallet::where([
                ['iduser', '=', $user->id],
                ['status', '=', 0],
                ['liquidado', '=', 0],
                ['tipo_transaction', '=', 0],
            ])->get();

            $bruto = $comisiones->sum('monto');
            if ($bruto < 50) {
                return 0;
            }

            $feed = ($bruto * 0.06);
            $total = ($bruto - $feed);

            $arrayLiquidation = [
                'iduser' => $user->id,
                'total' => $total,
                'monto_bruto' => $bruto,
                'feed' => $feed,
                'hash',
                'wallet_used' => $wallet,
                'status' => 0,
                'code_correo' => Str::random(10),
                'fecha_code' => Carbon::now(),
            ];
            $idLiquidation = $this->saveLiquidation($arrayLiquidation);

            $dataEmail = [
                'billetera' => $wallet,
                'total' => $total,
                'user' => $user->fullname,
                'code' => $arrayLiquidation['code_correo'],
            ];

            Mail::send('mail.SendCodeRetiro', $dataEmail, function ($msj) use ($user): void {
                $msj->subject('Codigo Retiro');
                $msj->to($user->email);
            });

            if (!empty($idLiquidation)) {
                $listComi = $comisiones->pluck('id');
                Wallet::whereIn('id', $listComi)->update([
                    'status' => 1,
                    'liquidation_id' => $idLiquidation,
                ]);
            }

            return $idLiquidation;
        } catch (Throwable $th) {
            Log::error('Liquidaction - sendCodeEmail -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite reversar los retiros que tienen mas de 30 min activos.
     */
    public function reversarRetiro30Min(): bool
    {
        $liquidation = Liquidaction::where([
            ['iduser', '=', Auth::id()],
            ['status', '=', 0],
        ])->first();
        $result = false;
        if ($liquidation != null) {
            $fechaActual = Carbon::now();
            $fechaCodeCorreo = new Carbon($liquidation->fecha_code);
            if ($fechaCodeCorreo->diffInMinutes($fechaActual) >= 30) {
                $this->reversarLiquidacion($liquidation->id, 'Tiempo limite de codigo sobrepasado');
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Permite revisar el estado de las ordenes en coinpayment y las reversas si fueron canceladas.
     */
    public function checkWithDrawCoinpayment(): void
    {
        $fecha = Carbon::now();
        $liquidaciones = Liquidaction::whereDate('created_at', '>=', $fecha->subDays(1))->where('status', 1)->orderBy('id', 'desc')->get();
        $cmd = 'get_withdrawal_info';
        foreach ($liquidaciones as $liquidacion) {
            if (!empty($liquidacion->hash) && strlen($liquidacion->hash) <= 32) {
                $data = ['id' => $liquidacion->hash];
                // Log::info('Liquidacion: '.$liquidacion->id);
                $resultado = $this->coinpayments_api_call($cmd, $data);
                // dump($resultado);
                if (!empty($resultado['result'])) {
                    if ($resultado['result']['status'] == -1) {
                        $this->reversarLiquidacion($liquidacion->id, 'Cancelado por coinpayment');
                        Log::info('Liquidacion: ' . $liquidacion->id . ' Fue Cancelada por coinpayment');
                    }
                }
            }
        }
    }
}
