<?php

namespace App\Http\Livewire;

use App\Models\Correo;
use Auth;
use Browser;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataCorreo extends Component
{
    use WithPagination;

    public $pagina = 'index';

    public $search;

    public function index(): void
    {
        $this->pagina = 'index';
    }

    public function render()
    {
        if (strlen($this->search) >= 3) { //buscar si es mayor a 3 caracteres

            //Log

            activity()
                ->causedBy(auth::user()->id)
                ->performedOn(new Correo())
                ->event('Search')
                ->withProperties([
                    'IP' => request()->ip(),
                    'browser' => Browser::browserName(),
                    'Os' => Browser::platformName(),
                ])
                ->log($this->search);

            return view(
                'livewire.elemento.data-correo',
                [
                    'correos' => DB::table('data_correos')
                        ->where('data_correos.correo', 'LIKE', '%' . $this->search . '%')
                        ->join('personas', 'personas.id', '=', 'data_correos.person_id')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->where('data_correos.deleted_at', null)
                        ->select(
                            'data_correos.correo as correo',
                            'personas.id as person_id',
                            'personas.nombres as nombres',
                            'personas.paterno as paterno',
                            'personas.materno as materno',
                            'info_tipo_documento_identidad.name as tipo_documento',
                            'personas.numero_documento as numero_documento'
                        )
                        ->orderBy('data_correos.id', 'desc')
                        ->paginate(5),

                ]
            )->extends('layouts.Master')->section('container');
        }

        return view(
            'livewire.elemento.data-correo',
            ['correos' => DB::table('data_correos')
                     ->join('personas', 'personas.id', '=', 'data_correos.person_id')
                     ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                     ->where('data_correos.deleted_at', null)
                     ->select(
                         'data_correos.correo as correo',
                         'personas.nombres as nombres',
                         'personas.paterno as paterno',
                         'personas.materno as materno',
                         'personas.id as person_id',
                         'info_tipo_documento_identidad.name as tipo_documento',
                         'personas.numero_documento as numero_documento'
                     )
                     ->orderBy('data_correos.id', 'desc')
                     ->limit(5)
                     ->paginate(5),
            ]
        )->extends('layouts.Master')->section('container');
    }
}
