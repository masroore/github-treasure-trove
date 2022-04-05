<?php

namespace App\Http\Livewire;

use DB;
use Livewire\Component;
use Livewire\WithPagination;

class LogLivewire extends Component
{
    public $event = 'index';

    public $s;

    use WithPagination;

    public function index(): void
    {
        $this->event = 'index';
    }

    public function render()
    {
        if (!empty($this->s)) {
            return view(
                'livewire.log',
                ['data' => DB::table('logs')
                 ->join('users', 'users.id', '=', 'logs.user_id')
                 ->Where('codigo', 'LIKE', '%' . $this->s . '%')
                 ->orWhere('log', 'LIKE', '%' . $this->s . '%')
                 ->orWhere('users.name', 'LIKE', '%' . $this->s . '%')
                 ->orWhere('users.lastname', 'LIKE', '%' . $this->s . '%')
                 ->orderBy('logs.id', 'desc')
                 ->paginate(20), ]
            );
        } //index

        return view('livewire.log', [
            'data' => DB::table('logs')
                ->join('users', 'users.id', '=', 'logs.user_id')
                ->orderBy('logs.id', 'desc')
                ->paginate(20),
        ])->extends('layouts.Master')
            ->section('container');
    }
}
