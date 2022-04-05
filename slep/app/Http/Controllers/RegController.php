<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegController extends Controller
{
    public function external_su(Request $request)
    {
        $today = date('Y-m-d');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');

        $empresa = Empresa::where('nombre', $request->empresa)->first();
        if ($empresa) {
            $user->empresas()->sync($empresa->id);
        } else {
            $new_empresa = new Empresa();
            $new_empresa->nombre = $request->empresa;
            $new_empresa->save();
            $user->empresas()->sync($new_empresa->id);
        }
        $user->deleted_at = $today;
        $user->save();

        return $user;
    }

    public function external_su_test(Request $request)
    {
        $today = date('Y-m-d');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('guest');

        $empresa = Empresa::where('nombre', $request->empresa)->first();
        if ($empresa) {
            $user->empresas()->sync($empresa->id);
        } else {
            $new_empresa = new Empresa();
            $new_empresa->nombre = $request->empresa;
            $new_empresa->save();
            $user->empresas()->sync($new_empresa->id);
        }
        //$user->deleted_at = $today;
        $user->save();

        return $user;
    }

    public function registro_onboarding(Request $request)
    {
        $today = date('Y-m-d');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('guest');

        $empresa = Empresa::where('nombre', $request->empresa)->first();
        if ($empresa) {
            $user->empresas()->sync($empresa->id);
        } else {
            $new_empresa = new Empresa();
            $new_empresa->nombre = $request->empresa;
            $new_empresa->save();
            $user->empresas()->sync($new_empresa->id);
        }
        //$user->deleted_at = $today;
        $user->save();

        return $user->id;
    }

    public function rg(Request $request)
    {
        $today = date('Y-m-d');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('gestor');

        $empresa = Empresa::where('nombre', $request->empresa)->first();
        if ($empresa) {
            $user->empresas()->sync($empresa->id);
        } else {
            $new_empresa = new Empresa();
            $new_empresa->nombre = $request->empresa;
            $new_empresa->save();
            $user->empresas()->sync($new_empresa->id);
        }
        //$user->deleted_at = $today;
        $user->save();

        return $user;
    }
}
