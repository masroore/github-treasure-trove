<?php

namespace App\Http\Controllers;

use App\Models\Inversion;
use App\Models\Liquidaction;
use App\Models\OrdenPurchases;
use App\Models\PorcentajeUtilidad;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletBinary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class WalletController extends Controller
{
    public $treeController;

    public function __construct()
    {
        $this->treeController = new TreeController();
    }

    /**
     * Lleva a la vista de la billetera.
     */
    public function index()
    {
        if (Auth::user()->admin == 1) {
            $wallets = Wallet::where('iduser', Auth::user()->id)->where('tipo_transaction', 0);
        } else {
            $wallets = Auth::user()->getWallet->where('tipo_transaction', 0);
        }
        $saldoDisponible = $wallets->where('status', 0)->sum('monto');

        return view('wallet.index', compact('wallets', 'saldoDisponible'));
    }

    /**
     * Lleva a la vista de pagos.
     */
    public function payments()
    {
        $payments = Liquidaction::where([['iduser', '=', Auth::user()->id], ['status', '=', '1']])->get();

        return view('wallet.payments', compact('payments'));
    }

    /**
     * Permita general el arreglo que se guardara en la wallet.
     */
    private function preSaveWallet(int $iduser, int $idreferido, ?int $cierre_id, float $monto, string $concepto): void
    {
        $data = [
            'iduser' => $iduser,
            'referred_id' => $idreferido,
            'orden_purchases_id' => $cierre_id,
            'monto' => $monto,
            'descripcion' => $concepto,
            'status' => 0,
            'tipo_transaction' => 0,
        ];

        $this->saveWallet($data);
    }

    /**
     * Permite obtener las compras de saldo de los ultimos 5 dias.
     *
     * @param int $iduser
     */
    public function getOrdens($iduser = null): object
    {
        try {
            $fecha = Carbon::now();
            if ($iduser == null) {
                $saldos = OrdenPurchases::where([
                    ['status', '=', '1'],
                ])
                    ->whereDate('created_at', '>=', $fecha->subDay(5))
                    ->get();
            } else {
                $saldos = OrdenPurchases::where([
                    ['iduser', '=', $iduser],
                    ['status', '=', '1'],
                ])->whereDate('created_at', '>=', $fecha->subDay(5))->get();
            }

            return $saldos;
        } catch (Throwable $th) {
            Log::error('Wallet - getOrdes -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite guardar la informacion de la wallet.
     *
     * @param array $data
     */
    public function saveWallet($data): void
    {
        try {
            if ($data['iduser'] != 1) {
                if ($data['tipo_transaction'] == 1) {
                    $wallet = Wallet::create($data);
                    $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['monto']);
                    $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                // $wallet->update(['balance' => $saldoAcumulado]);
                } else {
                    if ($data['orden_purchases_id'] != null) {
                        $check = Wallet::where([
                            ['iduser', '=', $data['iduser']],
                            ['orden_purchases_id', '=', $data['orden_purchases_id']],
                        ])->first();
                        if ($check == null) {
                            $wallet = Wallet::create($data);
                            $saldoAcumulado = ($wallet->getWalletUser->wallet + $data['monto']);
                            $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                            $this->aceleracion($data['iduser'], $data['referred_id'], $data['monto'], $data['descripcion']);
                        }
                    } else {
                        $wallet = Wallet::create($data);
                        $saldoAcumulado = ($wallet->getWalletUser->wallet + $data['monto']);
                        $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                        $this->aceleracion($data['iduser'], $data['referred_id'], $data['monto'], $data['descripcion']);
                    }
                    // $wallet->update(['balance' => $saldoAcumulado]);
                }
            }
        } catch (Throwable $th) {
            Log::error('Wallet - saveWallet -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite obtener el total disponible en comisiones.
     *
     * @param int $iduser
     */
    public function getTotalComision($iduser): float
    {
        try {
            $wallet = Wallet::where([['iduser', '=', $iduser], ['status', '=', 0]])->get()->sum('monto');
            if ($iduser == 1) {
                $wallet = Wallet::where([['status', '=', 0]])->get()->sum('monto');
            }

            return $wallet;
        } catch (Throwable $th) {
            Log::error('Wallet - getTotalComision -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite obtener el total de comisiones por meses.
     *
     * @param int $iduser
     */
    public function getDataGraphiComisiones($iduser)
    {
        try {
            $totalComision = [];
            if (Auth::user()->admin == 1) {
                $Comisiones = Wallet::select(DB::raw('SUM(monto) as Comision'))
                    ->where([
                        ['status', '<=', 1],
                    ])
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                    ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                    ->take(6)
                    ->get();
            } else {
                $Comisiones = Wallet::select(DB::raw('SUM(monto) as Comision'))
                    ->where([
                        ['iduser', '=',  $iduser],
                        ['status', '<=', 1],
                    ])
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                    ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                    ->take(6)
                    ->get();
            }
            foreach ($Comisiones as $comi) {
                $totalComision[] = $comi->Comision;
            }

            return $totalComision;
        } catch (Throwable $th) {
            Log::error('Wallet - getDataGraphiComisiones -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite pagar la rentabilidad.
     */
    public function pagarUtilidad(): void
    {
        $inversiones = Inversion::where('status', 1)->get();

        foreach ($inversiones as $inversion) {
            //establecemos maxima ganancia
            if ($inversion->max_ganancia == null) {
                $inversion->max_ganancia = $inversion->invertido * 2;
                $inversion->restante = $inversion->max_ganancia;
            }
            $porcentaje = PorcentajeUtilidad::orderBy('id', 'desc')->first();
            $cantidad = $inversion->invertido * $porcentaje->porcentaje_utilidad;
            $resta = $inversion->restante - $cantidad;

            if ($resta < 0) {//comparamos si se pasa de lo que puede ganar
                $cantidad = $inversion->restante;
                $inversion->restante = 0;
                $inversion->ganacia = $inversion->max_ganancia;
                $inversion->status = 2;
            } else {
                $inversion->restante = $resta;
                $inversion->ganacia += $cantidad;
            }
            $data = [
                'iduser' => $inversion->iduser,
                'referred_id' => null,
                'cierre_comision_id' => null,
                'monto' => $cantidad,
                'descripcion' => 'Profit de ' . ($porcentaje->porcentaje_utilidad * 100) . ' %',
                'status' => 0,
                'tipo_transaction' => 0,
                'orden_purchases_id' => $inversion->orden_id,
            ];

            if ($data['monto'] > 0) {
                $wallet = Wallet::create($data);
                $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['monto']);
                $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
            }

            $inversion->save();
        }
    }

    /**
     * Permite pagar la rentabilidad de forma manual llamando la funcion.
     */
    public function scriptPayRentabilidaManual($fecha, $porcentaje2): void
    {
        $fechaPago = new Carbon($fecha);
        $inversiones = Inversion::wheredate('created_at', '<=', $fechaPago)->where('status', 1)->get();

        foreach ($inversiones as $inversion) {
            //establecemos maxima ganancia
            if ($inversion->max_ganancia == null) {
                $inversion->max_ganancia = $inversion->invertido * 2;
                $inversion->restante = $inversion->max_ganancia;
            }
            $porcentaje = ($porcentaje2 / 100);
            $cantidad = $inversion->invertido * $porcentaje;
            $resta = $inversion->restante - $cantidad;

            if ($resta < 0) {//comparamos si se pasa de lo que puede ganar
                $cantidad = $inversion->restante;
                $inversion->restante = 0;
                $inversion->ganacia = $inversion->max_ganancia;
                $inversion->status = 2;
            } else {
                $inversion->restante = $resta;
                $inversion->ganacia += $cantidad;
            }
            $data = [
                'iduser' => $inversion->iduser,
                'referred_id' => null,
                'cierre_comision_id' => null,
                'monto' => $cantidad,
                'descripcion' => 'Profit de ' . ($porcentaje * 100) . ' %',
                'status' => 0,
                'tipo_transaction' => 0,
                'orden_purchases_id' => $inversion->orden_id,
            ];

            if ($data['monto'] > 0) {
                $wallet = Wallet::create($data);
                $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['monto']);
                $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
            }

            $inversion->save();
        }
    }

    /**
     * Permite accelarar el proceso de la barra de rentabilidad.
     *
     * @param int $iduser
     * @param int $idreferido
     * @param float $totalComision
     * @param string $concepto
     */
    public function aceleracion($iduser, $idreferido, $totalComision, $concepto): void
    {
        $inversion = Inversion::where([
            ['iduser', '=', $iduser],
            ['status', '=', 1],
        ])->first();
        if ($inversion != null) {
            //establecemos maxima ganancia
            if ($inversion->max_ganancia == null) {
                $inversion->max_ganancia = $inversion->invertido * 2;
                $inversion->restante = $inversion->max_ganancia;
            }
            $porcentaje = PorcentajeUtilidad::orderBy('id', 'desc')->first();
            $cantidad = $totalComision;
            $resta = $inversion->restante - $cantidad;

            if ($resta < 0) {//comparamos si se pasa de lo que puede ganar
                $cantidad = $inversion->restante;
                $inversion->restante = 0;
                $inversion->ganacia = $inversion->max_ganancia;
                $inversion->status = 2;
            } else {
                $inversion->restante = $resta;
                $inversion->ganacia += $cantidad;
            }
            // $data = [
            //     'iduser' => $inversion->iduser,
            //     'referred_id' => $idreferido,
            //     'cierre_comision_id' => null,
            //     'monto' => $cantidad,
            //     'descripcion' => 'Profit -> '.$concepto,
            //     'status' => 0,
            //     'tipo_transaction' => 0,
            //     'orden_purchases_id' => $inversion->orden_id
            // ];

            // if($data['monto'] > 0){
            //     $wallet = Wallet::create($data);
            //     // $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['monto']);
            //     // $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
            // }

            $inversion->save();
        }
    }

    /**
     * Permite pagar el bono directo.
     */
    public function bonoDirecto(): void
    {
        try {
            $ordenes = $this->getOrdens(null);
            // dd($ordenes);
            foreach ($ordenes as $orden) {
                $comision = ($orden->total * 0.1);
                $sponsor = User::find($orden->getOrdenUser->referred_id);
                if ($sponsor->status == '1') {
                    $concepto = 'Bono directo del Usuario ' . $orden->iduser;
                    if (!empty($orden->getOrdenUser)) {
                        $concepto = 'Bono directo del Usuario ' . $orden->getOrdenUser->fullname;
                    }

                    $this->preSaveWallet($sponsor->id, $orden->iduser, $orden->id, $comision, $concepto);
                } else {
                    $concepto = 'Bono directo del Usuario ' . $orden->getOrdenUser->fullname;
                    $this->preSaveWallet($sponsor->id, $orden->iduser, $orden->id, 0, $concepto);
                }
            }
        } catch (Throwable $th) {
            Log::error('Wallet - bonoDirecto -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite pagar los puntos binarios.
     */
    public function payPointsBinary(): void
    {
        try {
            $ordenes = $this->getOrdens(null);
            foreach ($ordenes as $orden) {
                $sponsors = $this->treeController->getSponsor($orden->iduser, [], 0, 'id', 'binary_id');
                $side = $orden->getOrdenUser->binary_side;
                foreach ($sponsors as $sponsor) {
                    $campo = ($side == 'I') ? 'not_payment_binary_point_izq' : 'not_payment_binary_point_der';
                    $checkFirstPurchase = 1;
                    //Permite verificar si ya el padre tiene un usuario que no pague binario por los dos lados
                    $checkUserBinaryPayment = User::where([
                        [$campo, '=', $orden->id],
                        ['id', '=', $sponsor->id],
                    ])->first();

                    if (!empty($checkUserBinaryPayment)) {
                        if ($orden->getOrdenUser->referred_id == $sponsor->id) {
                            $checkFirstPurchase = 0;
                        }
                    }
                    if ($checkFirstPurchase == 1) {
                        if ($sponsor->id != $orden->iduser) {
                            if ($sponsor->id != 1) {
                                $check = WalletBinary::where([
                                    ['iduser', '=', $sponsor->id],
                                    ['referred_id', '=', $orden->iduser],
                                    ['orden_purchase_id', '=', $orden->id],
                                ])->first();
                                if (empty($check)) {
                                    $concepto = 'Puntos binarios del Usuario ' . $orden->getOrdenUser->fullname;
                                    $puntosD = $puntosI = $puntos_real = 0;
                                    if ($sponsor->status == '1') {
                                        $puntos_real = $orden->total;
                                        if ($side == 'I') {
                                            $puntosI = $orden->total;
                                        } elseif ($side == 'D') {
                                            $puntosD = $orden->total;
                                        }
                                    }
                                    $dataWalletPoints = [
                                        'iduser' => $sponsor->id,
                                        'referred_id' => $orden->iduser,
                                        'orden_purchase_id' => $orden->id,
                                        'puntos_d' => $puntosD,
                                        'puntos_i' => $puntosI,
                                        'side' => $side,
                                        'status' => 0,
                                        'descripcion' => $concepto,
                                        'puntos_reales' => $puntos_real,
                                    ];

                                    WalletBinary::create($dataWalletPoints);
                                }
                            }
                        }
                    }
                    $side = $sponsor->binary_side;
                }
            }
        } catch (Throwable $th) {
            Log::error('Wallet - payPointsBinary -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite pagar el bono binario.
     */
    public function bonoBinario(): void
    {
        $binarios = WalletBinary::where([
            ['status', '=', 0],
            ['puntos_d', '>', 0],
        ])->orWhere([
            ['status', '=', 0],
            ['puntos_i', '>', 0],
        ])->selectRaw('iduser, SUM(puntos_d) as totald, SUM(puntos_i) as totali')->groupBy('iduser')->get();

        foreach ($binarios as $binario) {
            $puntos = 0;
            $side_mayor = $side_menor = '';
            if ($binario->totald >= $binario->totali) {
                $puntos = $binario->totali;
                $side_mayor = 'D';
                $side_menor = 'I';
            } else {
                $puntos = $binario->totald;
                $side_mayor = 'I';
                $side_menor = 'D';
            }
            if ($puntos > 0) {
                $comision = ($puntos * 0.1);
                $sponsor = User::find($binario->iduser);
                $this->setPointBinaryPaid($puntos, $side_menor, $binario->iduser, $side_mayor);
                if ($this->verificarBinario($sponsor->id)) {
                    $sponsor->point_rank += $puntos;
                    $concepto = 'Bono Binario - ' . $puntos;
                    $idcomision = $binario->iduser . Carbon::now()->format('Ymd');
                    $this->preSaveWallet($sponsor->id, $sponsor->id, null, $comision, $concepto);
                    $sponsor->save();
                }
            }
        }
    }

    /**
     * Permite verificar si un usuario tiene el binario activo.
     *
     * @param int $iduser
     */
    public function verificarBinario($iduser): bool
    {
        $result = false;
        $checBinaryIzquierdo = User::where([
            ['binary_side', '=', 'I'],
            ['status', '=', '1'],
            ['referred_id', '=', $iduser],
        ])->first();
        $checBinaryDerecho = User::where([
            ['binary_side', '=', 'D'],
            ['status', '=', '1'],
            ['referred_id', '=', $iduser],
        ])->first();
        if (!empty($checBinaryIzquierdo) && !empty($checBinaryDerecho)) {
            $result = true;
        }

        return $result;
    }

    /**
     * Permite descontar los puntos ya pagados.
     */
    private function setPointBinaryPaid(float $pagar, string $ladomenor, int $iduser, string $ladomayor): void
    {

        //LADO MAYOR
        $lisComision = [];
        $binarios = WalletBinary::where([
            ['side', '=', $ladomayor],
            ['iduser', '=', $iduser],
            ['status', '=', 0],
        ])->orderBy('id', 'asc')->get();

        $field_side = ($ladomayor == 'D') ? 'puntos_d' : 'puntos_i';
        $pagar_copy = $pagar;
        foreach ($binarios as $binario) {
            $wallet = WalletBinary::findOrFail($binario->id);

            if ($pagar_copy > 0) {
                if ($pagar_copy <= $binario->$field_side) {
                    $adecontar = $pagar_copy;
                } else {
                    $adecontar = $binario->$field_side;
                }
                $pagar_copy -= $adecontar;
                $wallet->$field_side -= $adecontar;
                if ($wallet->$field_side == 0) {
                    $lisComision[] = $binario->id;
                }
                $wallet->save();
            } else {
                break;
            }
        }
        WalletBinary::whereIn('id', $lisComision)->update(['status' => '1']);

        //LADO MENOR
        $lisComision = [];
        $binarios = WalletBinary::where([
            ['side', '=', $ladomenor],
            ['iduser', '=', $iduser],
            ['status', '=', 0],
        ])->orderBy('id', 'asc')->get();

        $field_side = ($ladomenor == 'I') ? 'puntos_i' : 'puntos_d';
        $pagar_copy = $pagar;
        foreach ($binarios as $binario) {
            $wallet = WalletBinary::findOrFail($binario->id);

            if ($pagar_copy > 0) {
                if ($pagar_copy <= $binario->$field_side) {
                    $adecontar = $pagar_copy;
                } else {
                    $adecontar = $binario->$field_side;
                }
                $pagar_copy -= $adecontar;
                $wallet->$field_side -= $adecontar;
                if ($wallet->$field_side == 0) {
                    $lisComision[] = $binario->id;
                }
                $wallet->save();
            } else {
                break;
            }
        }
        WalletBinary::whereIn('id', $lisComision)->update(['status' => '1']);
    }

    /**
     * Permite pagar todo los bonos y puntos.
     */
    public function payAll(): void
    {
        $this->bonoDirecto();
        Log::info('Bono Directo Pagado');
        $this->payPointsBinary();
        Log::info('Puntos Binarios Pagado');
        if (env('APP_ENV' != 'local')) {
            $this->bonoBinario();
        }
    }
}
