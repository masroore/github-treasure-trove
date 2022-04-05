<?php

namespace App\Http\Livewire;

use App\Models\CuentaBancaria;
use Browser;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataCuentaBancaria extends Component
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
                ->performedOn(new CuentaBancaria())
                ->event('Search')
                ->withProperties([
                    'IP' => request()->ip(),
                    'browser' => Browser::browserName(),
                    'Os' => Browser::platformName(),
                ])
                ->log($this->search);

            return view(
                'livewire.elemento.data-cuenta-bancaria',
                [
                    'cuentasBancarias' => DB::table('data_cuenta_bancarias')
                        ->where('data_cuenta_bancarias.cuenta_bancaria', 'LIKE', '%' . $this->search . '%')
                        ->join('info_bancos', 'info_bancos.id', '=', 'data_cuenta_bancarias.banco_id')
                        ->join('info_monedas', 'info_monedas.id', '=', 'data_cuenta_bancarias.moneda_id')
                        ->join('personas', 'personas.id', '=', 'data_cuenta_bancarias.person_id')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->where('data_cuenta_bancarias.deleted_at', null)
                        ->select(
                            'data_cuenta_bancarias.cuenta_bancaria as cuenta',
                            'info_bancos.banco as banco',
                            'info_monedas.moneda as moneda',
                            'personas.id as person_id',
                            'personas.nombres as nombres',
                            'personas.paterno as paterno',
                            'personas.materno as materno',
                            'info_tipo_documento_identidad.name as tipo_documento',
                            'personas.numero_documento as numero_documento'
                        )
                        ->orderBy('data_cuenta_bancarias.id', 'desc')
                        ->paginate(5),

                ]
            )->extends('layouts.Master')->section('container');
        }

        return view(
            'livewire.elemento.data-cuenta-bancaria',
            ['cuentasBancarias' => DB::table('data_cuenta_bancarias')
                     ->join('info_bancos', 'info_bancos.id', '=', 'data_cuenta_bancarias.banco_id')
                     ->join('info_monedas', 'info_monedas.id', '=', 'data_cuenta_bancarias.moneda_id')
                     ->join('personas', 'personas.id', '=', 'data_cuenta_bancarias.person_id')
                     ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                     ->where('data_cuenta_bancarias.deleted_at', null)
                     ->select(
                         'data_cuenta_bancarias.cuenta_bancaria as cuenta',
                         'info_monedas.moneda as moneda',
                         'info_bancos.banco as banco',
                         'personas.nombres as nombres',
                         'personas.paterno as paterno',
                         'personas.materno as materno',
                         'personas.id as person_id',
                         'info_tipo_documento_identidad.name as tipo_documento',
                         'personas.numero_documento as numero_documento'
                     )
                     ->orderBy('data_cuenta_bancarias.id', 'desc')
                     ->limit(5)
                     ->paginate(5),
            ]
        )->extends('layouts.Master')->section('container');
    }
}
