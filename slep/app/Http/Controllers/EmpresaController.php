<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;

use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function crearEmpresa(Request $request): void
    {
        $nuevaEmpresa = new Empresa();
        $nuevaEmpresa->nombre = $request->nombreEmpresa;
        $nuevaEmpresa->save();
    }

    public function GetAll()
    {
        return Empresa::all();
    }

    public function asociarEmpresa(Request $request)
    {
        $user = User::where('id', auth()->id())->first();
        $user->empresas()->sync($request->e_ids);

        return dd($request->all());
    }
}
