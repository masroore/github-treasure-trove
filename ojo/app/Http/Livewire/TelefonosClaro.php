<?php

namespace App\Http\Livewire;

use App\Models\Log;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class TelefonosClaro extends Component
{
    use WithPagination;

    public $event;

    public $dni;

    public $name;

    public $telefono;

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

        $this->LogSAVE('CLARO DNI', $this->dni);
    }

    public function name(): void
    {
        $this->event = 'name';

        $this->LogSAVE('CLARO NOMBRE', $this->name);
    }

    public function telefono(): void
    {
        $this->event = 'telefono';

        $this->LogSAVE('CLARO TELEFONO', $this->telefono);
    }

    public function render()
    {
        if ($this->event == 'dni') {
            return view(
                'livewire.claro',
                ['data' => DB::table('claros')
                 ->Where('dni', '=', $this->dni)
                 ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'name') {
            return view(
                'livewire.claro',
                ['data' => DB::table('claros')
                 ->Where('nombre', 'LIKE', '%' . $this->name . '%')
                 ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'telefono') {
            return view(
                'livewire.claro',
                ['data' => DB::table('claros')
                 ->Where('numero', '=', '51' . $this->telefono)
                 ->paginate(20), ]
            );

            $this->reset();
        } else { //index

            return view('livewire.claro')->extends('layouts.Master')
                ->section('container');
        }
    }
}
