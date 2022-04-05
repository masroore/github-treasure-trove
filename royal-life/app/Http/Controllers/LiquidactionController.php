<?php

namespace App\Http\Controllers;

use App\Models\Liquidaction;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class LiquidactionController extends Controller
{
    public $walletController;

    public function __construct()
    {
        $this->walletController = new WalletController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $comisiones = $this->getTotalComisiones([], null);

            return view('settlement.index', compact('comisiones'));
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
            ];
            $idLiquidation = $this->saveLiquidation($arrayLiquidation);

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
                'hash' => ['required'],
            ]);
        } else {
            $validate = $request->validate([
                'comentario' => ['required'],
            ]);
        }

        try {
            if ($validate) {
                $idliquidation = $request->idliquidation;
                $accion = 'No Procesada';
                if ($request->action == 'reverse') {
                    $accion = 'Reversada';
                    $this->reversarLiquidacion($idliquidation, $request->comentario);
                } elseif ($request->action == 'aproved') {
                    $accion = 'Aprobada';
                    $this->aprovarLiquidacion($idliquidation, $request->hash);
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
     * @param string $hash
     */
    public function aprovarLiquidacion($idliquidation, $hash): void
    {
        Liquidaction::where('id', $idliquidation)->update([
            'status' => 1,
            'hash' => $hash,
        ]);

        Wallet::where('liquidation_id', $idliquidation)->update(['liquidado' => 1]);
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

    public function retirarSaldo(Request $request)
    {
        try {
            $user = Auth::user();

            $comisiones = Wallet::where([
                ['iduser', '=', $user->id],
                ['status', '=', 0],
                ['tipo_transaction', '=', 0],
            ])->get();

            $bruto = $comisiones->sum('monto');
            if ($bruto < 50) {
                return redirect()->back()->with('msj-danger', 'El monto minimo de retirar es 50 Usd');
            }

            $feed = ($bruto * 0.06);
            $total = ($bruto - $feed);

            $arrayLiquidation = [
                'iduser' => $user->id,
                'total' => $total,
                'monto_bruto' => $bruto,
                'feed' => $feed,
                'hash',
                'wallet_used' => $user->type_wallet . ' - ' . $user->wallet_address,
                'status' => 0,
            ];
            $idLiquidation = $this->saveLiquidation($arrayLiquidation);

            if (!empty($idLiquidation)) {
                $listComi = $comisiones->pluck('id');
                Wallet::whereIn('id', $listComi)->update([
                    'status' => 1,
                    'liquidation_id' => $idLiquidation,
                ]);
            }

            return redirect()->back()->with('msj-success', 'Saldo retirado con exito');
        } catch (Throwable $th) {
            Log::error('Liquidaction - generarLiquidation -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }
}
