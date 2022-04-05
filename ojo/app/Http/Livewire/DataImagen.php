<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Storage;

class DataImagen extends Component
{
    use WithPagination;

    public $pagina = 'index';

    public $show_status = false;

    public $selected_url;

    public function index(): void
    {
        $this->pagina = 'index';
    }

    public function show($image_url): void
    {
        $this->show_status = true;

        $this->selected_url = Storage::url($image_url);
    }

    public function render()
    {
        return view(
            'livewire.elemento.data-imagen',
            ['imagenes' => DB::table('data_imagenes')
                 ->join('personas', 'personas.id', '=', 'data_imagenes.person_id')
                 ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                 ->where('data_imagenes.deleted_at', null)
                 ->select(
                     'data_imagenes.id as image_id',
                     'data_imagenes.image_url as image_url',
                     'personas.nombres as nombres',
                     'personas.paterno as paterno',
                     'personas.materno as materno',
                     'personas.id as person_id',
                     'info_tipo_documento_identidad.name as tipo_documento',
                     'personas.numero_documento as numero_documento'
                 )
                 ->orderBy('data_imagenes.id', 'desc')
                 ->paginate(5),
            ]
        )->extends('layouts.Master')->section('container');
    }
}
