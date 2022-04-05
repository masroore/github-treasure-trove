<?php

namespace App\Http\Livewire;

use App\Models\Log;
use Auth;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class TelefonosEntel extends Component
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

        $this->LogSAVE('ENTEL DNI', $this->dni);
    }

    public function name(): void
    {
        $this->event = 'name';

        $this->LogSAVE('ENTEL NOMBRE', $this->name);
    }

    public function telefono(): void
    {
        $this->event = 'telefono';

        $this->LogSAVE('ENTEL TELEFONO', $this->telefono);
    }

    public function render()
    {
        if ($this->event == 'dni') {
            logs(Auth::id(), 'Entel DNI', $this->dni);

            return view(
                'livewire.entel',
                ['data' => DB::table('entels')
                    ->Where('nro_doc', '=', $this->dni)
                    ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'name') {
            logs(Auth::id(), 'Entel Name', $this->name);

            return view(
                'livewire.entel',
                ['data' => DB::table('entels')
                    ->Where('nombre_completo', 'LIKE', '%' . $this->name . '%')
                    ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'telefono') {
            logs(Auth::id(), 'Entel Phone', $this->telefono);

            return view(
                'livewire.entel',
                ['data' => DB::table('entels')
                    ->Where('Tel1', '=', $this->telefono)
                    ->orWhere('Tel2', '=', $this->telefono)
                    ->orWhere('Tel3', '=', $this->telefono)
                    ->orWhere('Tel4', '=', $this->telefono)
                    ->orWhere('Tel5', '=', $this->telefono)
                    ->paginate(20), ]
            );

            $this->reset();
        } else { //index

            return view('livewire.entel')->extends('layouts.Master')
                ->section('container');
        }
    }
}
