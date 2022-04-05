<?php

namespace App\Http\Livewire;

use App\Models\Tarjeta;
use Browser;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataTarjeta extends Component
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
                ->performedOn(new Tarjeta())
                ->event('Search')
                ->withProperties([
                    'IP' => request()->ip(),
                    'browser' => Browser::browserName(),
                    'Os' => Browser::platformName(),
                ])
                ->log($this->search);

            return view(
                'livewire.elemento.data-tarjeta',
                [
                    'tarjetas' => DB::table('data_tarjetas')
                        ->where('data_tarjetas.numero_tarjeta', 'LIKE', '%' . $this->search . '%')
                        ->join('info_bancos', 'info_bancos.id', '=', 'data_tarjetas.banco_id')
                        ->join('personas', 'personas.id', '=', 'data_tarjetas.person_id')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->where('data_tarjetas.deleted_at', null)
                        ->select(
                            'data_tarjetas.numero_tarjeta as tarjeta',
                            'info_bancos.banco as banco',
                            'personas.id as person_id',
                            'personas.nombres as nombres',
                            'personas.paterno as paterno',
                            'personas.materno as materno',
                            'info_tipo_documento_identidad.name as tipo_documento',
                            'personas.numero_documento as numero_documento'
                        )
                        ->orderBy('data_tarjetas.id', 'desc')
                        ->paginate(5),

                ]
            )->extends('layouts.Master')->section('container');
        }

        return view(
            'livewire.elemento.data-tarjeta',
            ['tarjetas' => DB::table('data_tarjetas')
                     ->join('info_bancos', 'info_bancos.id', '=', 'data_tarjetas.banco_id')
                     ->join('personas', 'personas.id', '=', 'data_tarjetas.person_id')
                     ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                     ->where('data_tarjetas.deleted_at', null)
                     ->select(
                         'data_tarjetas.numero_tarjeta as tarjeta',
                         'info_bancos.banco as banco',
                         'personas.nombres as nombres',
                         'personas.paterno as paterno',
                         'personas.materno as materno',
                         'personas.id as person_id',
                         'info_tipo_documento_identidad.name as tipo_documento',
                         'personas.numero_documento as numero_documento'
                     )
                     ->orderBy('data_tarjetas.id', 'desc')
                     ->limit(5)
                     ->paginate(5),
            ]
        )->extends('layouts.Master')->section('container');
    }
}
