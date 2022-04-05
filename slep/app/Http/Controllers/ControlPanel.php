<?php

namespace App\Http\Controllers;

use App\Models\AsyncResult;
use App\Models\Busqueda;

use App\Models\Empresa;
use App\Models\Medio;
use App\Models\User;
use App\Models\WsStatu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ControlPanel extends Controller
{
    public function dt()
    {
        $title = 'Datatables de prueba';
        $data = AsyncResult::all();

        return view('dashboard/controlpanel', compact('data', 'title'));
    }

    public function busquedas()
    {
        $title = 'Busquedas';
        //$data = Busqueda::with('user')->with('campañas')->with('async')->with('googlenews')->get();
        $data = [];

        return view('dashboard/controlpanel', compact('data', 'title'));
    }

    public function async()
    {
        $title = 'Resultados Asíncronos';
        $data = AsyncResult::all();

        return view('dashboard/controlpanel', compact('data', 'title'));
    }

    public function ws()
    {
        $title = 'Web Services';
        $data = WsStatu::all();

        return view('dashboard/controlpanel', compact('data', 'title'));
    }

    public function roles()
    {
        $title = 'Roles';
        $data = User::with('roles')->get();

        return view('dashboard/controlpanel', compact('data', 'title'));
    }

    public function edit_roles_row(Request $r): void
    {
        $usr = User::where('id', $r->id)->first();
        $usr->name = $r->name;
        $usr->email = $r->email;
        ($r->rol == 1) ? $usr->roles()->sync([1, 2]) : $usr->roles()->sync($r->rol);
        $usr->save();
    }

    public function delete_roles_row(Request $r): void
    {
        $usr = User::where('id', $r->id)->first();
        $usr->deleted_at = date('Y-m-d');
        $usr->save();
    }

    public function new(Request $r)
    {
        $today = date('Y-m-d');
        $usr = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
        ]);
        ($r->rol == 1) ? $usr->roles()->sync([1, 2]) : $usr->roles()->sync($r->rol);
        $empresa = Empresa::where('nombre', $r->empresa)->first();
        if ($empresa) {
            $usr->empresas()->sync($empresa->id);
        } else {
            $new_empresa = new Empresa();
            $new_empresa->nombre = $r->empresa;
            $new_empresa->save();
            $usr->empresas()->sync($new_empresa->id);
        }
        $usr->save();

        return $usr->id;
    }

    public function medios()
    {
        $title = 'Medios Sociales';
        $data = Medio::all();

        return view('dashboard/controlpanel', compact('data', 'title'));
    }

    public function edit_medios_row(Request $r)
    {
        if ($r->hasFile('imagen2')) {
            request()->validate(['imagen2' => 'required|mimes:png,svg|max:2048']);
            $file = $r->file('imagen2');
            $filename = $r->id . '.png';
            $path = public_path() . '/assets/img/medios_images';
            $upload = $file->move($path, $filename);
        }

        $obj = Medio::where('id', $r->id)->first();

        $img_final = 'Sin imagen';
        if (null === $r->imagen2) {
            $img_final = 'Sin imagen';
        } elseif ($r->imagen2 == 'same') {
            $img_final = $obj->imagen;
        } else {
            $img_final = $filename;
        }

        $medio = Medio::where('id', $r->id)->update([
            'tipo_medio' => $r->tipo_medio,
            'alcance' => $r->alcance,
            'url' => (null === $r->url ? 'Sin url' : isset($url_validada)) ? 'Sin url' : $r->url,
            'nombre' => $r->nombre,
            'imagen' => $img_final,
        ]);

        return Medio::where('id', $r->id)->first();
    }

    public function delete_medios_row(Request $r): void
    {
        $medio = Medio::where('id', $r->id)->first();
        $medio->deleted_at = date('Y-m-d');
        $medio->save();
    }

    public function new_medio(Request $r)
    {
        if (filter_var($r->url, FILTER_VALIDATE_URL) === false) {
            $url_validada = 'Url Invalida';
        }

        //return dd($r->all());
        $model = Medio::create([
            'tipo_medio' => $r->tipo_medio,
            'alcance' => $r->alcance,
            'url' => (null === $r->url ? 'Sin url' : isset($url_validada)) ? 'Sin url' : $r->url,
            'nombre' => $r->nombre,
            'imagen' => 'Sin imagen',
        ]);

        if ($r->hasFile('imagen2')) {
            request()->validate(['imagen2' => 'required|mimes:png,svg|max:2048']);
            $file = $r->file('imagen2');
            $filename = $model->id . '.png';
            $path = public_path() . '/assets/img/medios_images';
            $upload = $file->move($path, $filename);
        }

        Medio::where('id', $model->id)->update([
            'imagen' => (null === $r->imagen2) ? 'Sin imagen' : $filename,
        ]);

        return Medio::where('id', $model->id)->first();
    }
}
