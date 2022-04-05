<?php

namespace App\Http\Livewire;

use App\Models\Log;
use Auth;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class TelefonosMovistar extends Component
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

        $this->LogSAVE('MOVISTAR DNI', $this->dni);
    }

    public function name(): void
    {
        $this->event = 'name';

        $this->LogSAVE('MOVISTAR NOMBRE', $this->name);
    }

    public function telefono(): void
    {
        $this->event = 'telefono';

        $this->LogSAVE('MOVISTAR TELEFONO', $this->telefono);
    }

    public function render()
    {
        if ($this->event == 'dni') {
            logs(Auth::id(), 'Movistar DNI', $this->dni);

            return view(
                'livewire.movistar',
                ['data' => DB::table('movistars')
                    ->Where('NumeroIdentificacionPersona', '=', $this->dni)
                    ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'name') {
            logs(Auth::id(), 'Movistar Name', $this->name);

            return view(
                'livewire.movistar',
                ['data' => DB::table('movistars')
                    ->Where('RazonSocial', 'LIKE', '%' . $this->name . '%')
                    ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'telefono') {
            logs(Auth::id(), 'Movistar Phone', $this->telefono);

            return view(
                'livewire.movistar',
                ['data' => DB::table('movistars')
                    ->Where('TELEFONO', '=', $this->telefono)
                    ->paginate(20), ]
            );

            $this->reset();
        } else { //index

            return view('livewire.movistar')->extends('layouts.Master')
                ->section('container');
        }
    }
}
