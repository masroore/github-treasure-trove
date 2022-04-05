<?php

namespace App\Http\Controllers;

use App\Models\CierreComision;
use App\Models\OrdenPurchases;
use App\Models\Packages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CierreComisionController extends Controller
{
    /**
     * Variable Global del WalletController.
     *
     * @var WalletController
     */
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
            // title
            $ordenes = OrdenPurchases::where('status', '=', '0')
                ->selectRaw('SUM(total) as ingreso, group_id, package_id')
                                    // ->whereDate('created_at', Carbon::now()->format('Ymd'))
                ->groupBy('package_id', 'group_id')
                ->get();
            foreach ($ordenes as $orden) {
                $orden->grupo = $orden->getGroupOrden->name;
                $orden->paquete = $orden->getPackageOrden->name;
                $cierre = CierreComision::where([
                    ['group_id', $orden->group_id], ['package_id', $orden->package_id],
                ])->whereDate('cierre', Carbon::now())->first();
                $orden->cerrada = ($cierre != null) ? 1 : 0;
            }

            return view('accounting.index', compact('ordenes'));
        } catch (Throwable $th) {
            Log::error('CierreComision - index -> Error: ' . $th);
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
        $validate = $request->validate([
            's_inicial' => ['required', 'numeric'],
            's_ingreso' => ['required', 'numeric'],
            's_final' => ['required', 'numeric'],
            'package_id' => ['required', 'numeric'],
        ]);

        try {
            if ($validate) {
                $paquete = Packages::find($request->package_id);
                $request['group_id'] = $paquete->group_id;
                $request['cierre'] = Carbon::now();
                $cierre = CierreComision::create($request->all());
                $ganacia = ($cierre->s_final - $cierre->s_inicial);
                $comisiones = $this->generateComision($ganacia, $cierre->package_id, $cierre->group_id, $cierre->s_final);
                foreach ($comisiones as $comision) {
                    $this->walletController->payComision($comision['comision'], $comision['iduser'], $comision['referido'], $cierre->id);
                }

                return redirect()->back()->with('msj-success', 'Cierre realizado y Comisiones pagadas con exito');
            }
        } catch (Throwable $th) {
            Log::error('CierreComision - store -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite general el pago de las comisiones.
     *
     * @param float $ganancia
     * @param int $paquete
     * @param int $grupo
     * @param float $saldo_cierre
     */
    private function generateComision($ganancia, $paquete, $grupo, $saldo_cierre): object
    {
        try {
            $ordenes = OrdenPurchases::where([
                ['status', '=', '0'],
                ['package_id', '=', $paquete],
                ['group_id', '=', $grupo],
            ])->selectRaw('SUM(total) as total, iduser')
            // ->whereDate('created_at', Carbon::now()->format('Ymd'))
                ->groupBy('iduser')
                ->get();
            $data = collect();

            foreach ($ordenes as $orden) {
                $porcentaje = (($orden->total / $saldo_cierre));
                $data->push([
                    'iduser' => $orden->iduser,
                    'comision' => round(($porcentaje * $ganancia), 2),
                    'referido' => $orden->getOrdenUser->fullname,
                ]);
            }

            return $data;
        } catch (Throwable $th) {
            Log::error('CierreComision - generateComision -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $paquete = Packages::find($id);
            $ultimoSaldo = CierreComision::where('package_id', $id)->select('s_final')->orderBy('id', 'desc')->first();
            $ingreso = $paquete->getOrdenPurchase->where('status', '0')->sum('total');
            // ->whereDate('created_at', Carbon::now()->format('Ymd'))
            // ->sum('total');
            $paquete->status = '0';
            $paquete->save();

            $data = collect([
                'paquete' => $paquete->getGroup->name . ' - ' . $paquete->name,
                'saldo_final' => ($ultimoSaldo != null) ? $ultimoSaldo->s_final : 0,
                'ingreso' => $ingreso,
            ]);

            return $data->toJson();
        } catch (Throwable $th) {
            Log::error('CierreComision - show -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
