<?php

namespace App\Http\Livewire;

use App\Models\Telefono;
use Auth;
use Browser;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataTelefono extends Component
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
        if (strlen($this->search) >= 3) { //buscar si es matyor a 3 caracteres

            //Log

            activity()
                ->causedBy(auth::user()->id)
                ->performedOn(new Telefono())
                ->event('Search')
                ->withProperties([
                    'IP' => request()->ip(),
                    'browser' => Browser::browserName(),
                    'Os' => Browser::platformName(),
                ])
                ->log($this->search);

            return view(
                'livewire.elemento.data-telefono',
                [
                    'telefonos' => DB::table('data_telefonos')
                        ->where('data_telefonos.telefono', 'LIKE', '%' . $this->search . '%')
                        ->join('info_operadoras', 'info_operadoras.id', '=', 'data_telefonos.operador_id')
                        ->join('info_sistemas', 'info_sistemas.id', '=', 'data_telefonos.sistema_id')
                        ->join('personas', 'personas.id', '=', 'data_telefonos.person_id')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->where('data_telefonos.deleted_at', null)
                        ->select(
                            'data_telefonos.telefono as telefono',
                            'info_sistemas.name as sistema',
                            'info_operadoras.name as operadora',
                            'personas.id as person_id',
                            'personas.nombres as nombres',
                            'personas.paterno as paterno',
                            'personas.materno as materno',
                            'info_tipo_documento_identidad.name as tipo_documento',
                            'personas.numero_documento as numero_documento'
                        )
                        ->orderBy('data_telefonos.id', 'desc')
                        ->paginate(5),

                ]
            )->extends('layouts.Master')->section('container');
        }

        return view(
            'livewire.elemento.data-telefono',
            ['telefonos' => DB::table('data_telefonos')
                     ->join('info_operadoras', 'info_operadoras.id', '=', 'data_telefonos.operador_id')
                     ->join('info_sistemas', 'info_sistemas.id', '=', 'data_telefonos.sistema_id')
                     ->join('personas', 'personas.id', '=', 'data_telefonos.person_id')
                     ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                     ->where('data_telefonos.deleted_at', null)
                     ->select(
                         'data_telefonos.telefono as telefono',
                         'info_sistemas.name as sistema',
                         'info_operadoras.name as operadora',
                         'personas.nombres as nombres',
                         'personas.paterno as paterno',
                         'personas.materno as materno',
                         'personas.id as person_id',
                         'info_tipo_documento_identidad.name as tipo_documento',
                         'personas.numero_documento as numero_documento'
                     )
                     ->orderBy('data_telefonos.id', 'desc')
                     ->limit(5)
                     ->paginate(5),
            ]
        )->extends('layouts.Master')->section('container');
    }
}
