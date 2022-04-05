<?php

namespace App\Http\Livewire;

use App\Models\Log;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class Reniec extends Component
{
    use WithPagination;

    public $event;

    public $dni;

    public $paterno;

    public $materno;

    public $nombres;

    public function LogSAVE($codigo, $loge): void
    {
        $data = new Log();

        $data->user_id = auth()->user()->id;

        $data->user_ip = $_SERVER['REMOTE_ADDR'];

        $data->codigo = $codigo;

        $data->log = $loge;

        $data->save();
    }

    public function dni(): void
    {
        $this->event = 'dni';

        $this->LogSAVE('RENIEC DNI', $this->dni);
    }

    public function buscar(): void
    {
        $this->event = 'buscar';

        $this->LogSAVE('RENIEC NOMBRES', $this->nombres . ' ' . $this->paterno . ' ' . $this->materno);
    }

    public function render()
    {
        if ($this->event == 'dni') {
            return view(
                'livewire.reniec',
                ['data' => DB::table('reniecs')
                     ->Where('DOCUMENTO', '=', $this->dni)
                     ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'buscar') {
            return view(
                'livewire.reniec',
                ['data' => DB::table('reniecs')
                     ->Where('NOMBRES', 'LIKE', '%' . $this->nombres . '%')
                     ->Where('PATERNO', 'LIKE', '%' . $this->paterno . '%')
                     ->Where('MATERNO', 'LIKE', '%' . $this->materno . '%')
                     ->paginate(20), ]
            );

            $this->reset();
        } else { //index

            return view('livewire.reniec')->extends('layouts.Master')
                ->section('container');
        }
    }
}
