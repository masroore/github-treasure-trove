<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UserActivity extends Component
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

            return view(
                'livewire.user-activity',
                [
                    'useractivities' => DB::table('activity_log')
                        ->where('activity_log.event', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('activity_log.description', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('users.nombres', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('users.paterno', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('users.materno', 'LIKE', '%' . $this->search . '%')
                        ->join('users', 'users.id', '=', 'activity_log.causer_id')
                        ->select(
                            'activity_log.description',
                            'activity_log.subject_type',
                            'activity_log.event',
                            'activity_log.properties',
                            'activity_log.created_at',
                            'users.id as user_id',
                            'users.nombres',
                            'users.paterno',
                            'users.materno'
                        )
                        ->orderBy('activity_log.id', 'desc')
                        ->paginate(25),

                ]
            )->extends('layouts.Master')->section('container');
        }

        return view(
            'livewire.user-activity',
            ['useractivities' => DB::table('activity_log')
                     ->join('users', 'users.id', '=', 'activity_log.causer_id')
                     ->select(
                         'activity_log.description',
                         'activity_log.subject_type',
                         'activity_log.event',
                         'activity_log.properties',
                         'activity_log.created_at',
                         'users.id as user_id',
                         'users.nombres',
                         'users.paterno',
                         'users.materno'
                     )
                     ->orderBy('activity_log.id', 'desc')
                     ->paginate(25),
            ]
        )->extends('layouts.Master')->section('container');
    }
}
