<?php

namespace App\Http\Livewire;

use App\Models\PaginaWeb;
use Browser;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataPaginaWeb extends Component
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
                ->performedOn(new PaginaWeb())
                ->event('Search')
                ->withProperties([
                    'IP' => request()->ip(),
                    'browser' => Browser::browserName(),
                    'Os' => Browser::platformName(),
                ])
                ->log($this->search);

            return view(
                'livewire.elemento.data-pagina-web',
                [
                    'PaginasWeb' => DB::table('data_paginas_web')
                        ->where('data_paginas_web.pagina_Web', 'LIKE', '%' . $this->search . '%')
                        ->join('personas', 'personas.id', '=', 'data_paginas_web.person_id')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->where('data_paginas_web.deleted_at', null)
                        ->select(
                            'data_paginas_web.pagina_Web as pagina_web',
                            'personas.id as person_id',
                            'personas.nombres as nombres',
                            'personas.paterno as paterno',
                            'personas.materno as materno',
                            'info_tipo_documento_identidad.name as tipo_documento',
                            'personas.numero_documento as numero_documento'
                        )
                        ->orderBy('data_paginas_web.id', 'desc')
                        ->paginate(5),

                ]
            )->extends('layouts.Master')->section('container');
        }

        return view(
            'livewire.elemento.data-pagina-web',
            ['PaginasWeb' => DB::table('data_paginas_web')
                     ->join('personas', 'personas.id', '=', 'data_paginas_web.person_id')
                     ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                     ->where('data_paginas_web.deleted_at', null)
                     ->select(
                         'data_paginas_web.pagina_Web as pagina_web',
                         'personas.nombres as nombres',
                         'personas.paterno as paterno',
                         'personas.materno as materno',
                         'personas.id as person_id',
                         'info_tipo_documento_identidad.name as tipo_documento',
                         'personas.numero_documento as numero_documento'
                     )
                     ->orderBy('data_paginas_web.id', 'desc')
                     ->limit(5)
                     ->paginate(5),
            ]
        )->extends('layouts.Master')->section('container');
    }
}
