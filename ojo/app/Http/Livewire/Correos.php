<?php

namespace App\Http\Livewire;

use App\Models\Log;
use Auth;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class Correos extends Component
{
    use WithPagination;

    public $event;

    public $dni;

    public $name;

    public $correo;

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

        $this->LogSAVE('EMAILS DNI', $this->dni);
    }

    public function name(): void
    {
        $this->event = 'name';

        $this->LogSAVE('EMAILS NOMBRE', $this->name);
    }

    public function correo(): void
    {
        $this->event = 'correo';

        $this->LogSAVE('EMAILS CORREO', $this->correo);
    }

    public function render()
    {
        if ($this->event == 'dni') {
            logs(Auth::id(), 'Correo DNI', $this->dni);

            return view(
                'livewire.correo',
                ['data' => DB::table('correos')
                    ->Where('nro_doc', '=', $this->dni)
                    ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'name') {
            logs(Auth::id(), 'Correo Name', $this->name);

            return view(
                'livewire.correo',
                ['data' => DB::table('correos')
                    ->Where('nombre_completo', 'LIKE', '%' . $this->name . '%')
                    ->paginate(20), ]
            );

            $this->reset();
        } elseif ($this->event == 'correo') {
            logs(Auth::id(), 'Correo', $this->correo);

            return view(
                'livewire.correo',
                ['data' => DB::table('correos')
                    ->Where('correo1', '=', $this->correo)
                    ->orWhere('correo1', '=', $this->correo)
                    ->orWhere('correo1', '=', $this->correo)
                    ->paginate(20), ]
            );

            $this->reset();
        } else { //index

            return view('livewire.correo')->extends('layouts.Master')
                ->section('container');
        }
    }
}
