<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class UsersPermissions extends Component
{
    use WithPagination;

    public $event = 'index';

    public $name;

    protected $rules = [
        'name' => 'required',
    ];

    public function index(): void
    {
        $this->event = 'index';
    }

    public function create(): void
    {
        $this->event = 'create';
    }

    public function store(): void
    {
        $this->validate();

        Permission::create(['name' => $this->name]);

        session()->flash('message', 'Permiso creado.');

        $this->event = 'index';
    }

    public function destroy($id): void
    {
        $permiso = Permission::find($id)->first();

        $permiso->delete();

        session()->flash('message', 'Permiso eliminado.');

        $this->event = 'index';
    }

    public function render()
    {
        return view('livewire.users-permissions', [
            'permisos' => Permission::all(),
        ])->extends('layouts.Master')
            ->section('container');
    }
}
