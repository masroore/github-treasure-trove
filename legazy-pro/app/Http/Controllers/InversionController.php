<?php

namespace App\Http\Controllers;

use App\Models\Inversion;
use App\Models\PorcentajeUtilidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class InversionController extends Controller
{
    /**
     * Lleva a a la vista de las inversiones.
     *
     * @param [type] $tipo
     */
    public function __construct()
    {
        // $this->middleware('kyc')->only('index');
    }

    public function index()
    {
        try {
            $this->checkStatus();

            if (Auth::user()->admin == 1) {
                $inversiones = Inversion::all();
            } else {
                $inversiones = Inversion::where('iduser', '=', Auth::id())->orderBy('status')->get();
            }

            foreach ($inversiones as $inversion) {
                $inversion->correo = $inversion->getInversionesUser->email;
            }

            return view('inversiones.index', compact('inversiones'));
        } catch (Throwable $th) {
            Log::error('InversionController - index -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    // public function index($tipo)
    // {
    //    try {
    //        $this->checkStatus();
    //         if ($tipo == '') {
    //             $inversiones = Inversion::all();
    //         } else {
    //             if (Auth::id() == 1) {
    //                 $inversiones = Inversion::where('status', '=', $tipo)->get();
    //             }else{
    //                 $inversiones = Inversion::where([['status', '=', $tipo], ['iduser', '=',Auth::id()]])->get();
    //             }
    //         }

    //         foreach ($inversiones as $inversion) {
    //             $inversion->correo = $inversion->getInversionesUser->email;
    //         }

    //         return view('inversiones.index', compact('inversiones'));
    //     } catch (\Throwable $th) {
    //         Log::error('InversionController - index -> Error: '.$th);
    //         abort(403, "Ocurrio un error, contacte con el administrador");
    //     }
    // }

    /**
     * Permite guardar las nuevas inversiones generadas.
     *
     * @param int $paquete - ID del Paquete Comprado
     * @param float $invertido - Monto Total Invertido
     * @param string $vencimiento - Fecha de Vencimiento del paquete
     * @param int $iduser - ID del usuario
     */
    public function saveInversion(int $paquete, float $invertido, $vencimiento, int $iduser)
    {
        try {
            $check = Inversion::where([
                ['iduser', '=', $iduser],
                ['package_id', '=', $paquete],
                ['status', '=', 1],
                //['orden_id', '=', $orden],
            ])->first();

            $checkActivos = Inversion::where([
                ['iduser', '=', $iduser],
                ['status', '=', 1],
            ])->get()->count('id');
            // Inversion nueva
            if ($checkActivos == 0 && $check == null) {
                $data = [
                    'iduser' => $iduser,
                    'package_id' => $paquete,
                    //'orden_id' => $orden,
                    'invertido' => $invertido,
                    'ganacia' => 0,
                    'retiro' => 0,
                    'capital' => $invertido,
                    'progreso' => 0,
                    'fecha_vencimiento' => $vencimiento,
                    'ganancia_acumulada' => 0,
                ];

                $inversion = Inversion::create($data);

                return $inversion->id;
            }
            // Actualizar la inversion
            if ($checkActivos == 1) {
                $check = Inversion::where([
                    ['iduser', '=', $iduser],
                    ['status', '=', 1],
                ])->first();
                if ($paquete > $check->package_id) {
                    Inversion::where('id', $check->id)->update([
                        'package_id' => $paquete,
                        'invertido' => $invertido,
                        'capital' => $invertido,
                    ]);
                }

                return $check->id;
            }
        } catch (Throwable $th) {
            Log::error('InversionController - saveInversion -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    /**
     * Permite Verificar si una inversion esta terminada.
     */
    public function checkStatus(): void
    {
        Inversion::whereDate('fecha_vencimiento', '<', Carbon::now())->update(['status' => 2]);
    }

    public function updateGanancia(int $iduser, $paquete, float $ganacia, int $ordenId = 0, $porcentaje = null): void
    {
        try {
            if ($ordenId != 0) {
                $inversion = Inversion::where([
                    ['iduser', '=', $iduser],
                    ['status', '=', 1],
                    ['orden_id', '=', $ordenId],
                ])->first();
            } else {
                $inversion = Inversion::where([
                    ['iduser', '=', $iduser],
                    ['status', '=', 1],
                ])->first();
            }

            if ($inversion != null) {
                $capital = ($inversion->capital + $ganacia);
                $inversion->ganacia = ($inversion->ganacia + $ganacia);
                $inversion->capital = $capital;
                $inversion->porcentaje_fondo = $porcentaje;

                $inversion->save();
            }
        } catch (Throwable $th) {
            Log::error('InversionController - updateGanancia -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    public function updatePorcentaje(int $iduser, int $paquete, float $ganacia, int $ordenId = 0, $porcentaje = null): void
    {
        try {
            if ($ordenId != 0) {
                $inversion = Inversion::where([
                    ['iduser', '=', $iduser],
                    ['status', '=', 1],
                    ['orden_id', '=', $ordenId],
                ])->first();
            } else {
                $inversion = Inversion::where([
                    ['iduser', '=', $iduser],
                    ['package_id', '=', $paquete],
                    ['status', '=', 1],
                ])->first();
            }

            if ($inversion != null) {
                $inversion->porcentaje_fondo = $porcentaje;

                $inversion->save();
            }
        } catch (Throwable $th) {
            Log::error('InversionController - updateGanancia -> Error: ' . $th);
            abort(403, 'Ocurrio un error, contacte con el administrador');
        }
    }

    public function updatePorcentajeGanancia(Request $request)
    {
        $porcentaje = $request->porcentaje_ganancia / 100;

        $porcentajeUtilidad = PorcentajeUtilidad::orderBy('id', 'desc')->first();

        if ($porcentajeUtilidad == null) {
            PorcentajeUtilidad::create(['porcentaje_utilidad' => $porcentaje]);
        } else {
            $porcentajeUtilidad->update(['porcentaje_utilidad' => $porcentaje]);
        }

        return redirect()->back()->with('msj-success', 'Porcentaje actualizado correctamente');
    }
}
