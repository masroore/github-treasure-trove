<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserGroup;

use DB;
use Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Users extends Component
{
    use WithPagination;

    public $event = 'index';

    public $data;

    public $s;

    public $user_id;

    public $nombres;

    public $paterno;

    public $materno;

    public $dni;

    public $password;

    public $email;

    public $telefono;

    public $PermissionAll;

    public $UserPermission;

    public $registroPermisos = [];

    public $grupos;

    public $grupo_id;

    protected $rules = [
        'nombres' => 'required',
        'paterno' => 'required',
        'dni' => 'required|numeric',
        'materno' => 'required',
        'telefono' => 'required',
        'grupo_id' => 'required|numeric',
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function index(): void
    {
        $this->event = 'index';
    }

    public function changeStatus($id): void
    {
        $user = User::find($id);
        $last_status = $user->is_active;

        if ($last_status == 1) {
            $user->is_active = 0;
        } else {
            $user->is_active = 1;
        }

        $user->save();
    }

    public function reset2FA($id): void
    {
        $user = User::find($id);
        $user->google2fa_enable = 0;
        $user->google2fa_secret = null;
        $user->save();
    }

    public function create(): void
    {
        $this->reset();

        $this->PermissionAll = Permission::all();

        $this->grupos = UserGroup::all();

        $this->event = 'create';
    }

    public function store(): void
    {
        $this->validate();

        $user = User::create([
            'nombres' => $this->nombres,
            'paterno' => $this->paterno,
            'materno' => $this->materno,
            'dni' => $this->dni,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'grupo_id' => $this->grupo_id,
            'password' => Hash::make($this->password),
        ]);

        $user->givePermissionTo($this->registroPermisos);

        $this->reset();

        $this->event = 'index';
    }

    public function edit($id): void
    {
        $user = User::find($id);

        $this->user_id = $user->id;
        $this->nombres = $user->nombres;
        $this->paterno = $user->paterno;
        $this->materno = $user->materno;
        $this->dni = $user->dni;
        $this->telefono = $user->telefono;
        $this->email = $user->email;

        $this->UserPermission = $user->permissions->pluck('name');

        $this->PermissionAll = Permission::all();

        $this->event = 'edit';
    }

    public function ChangePermission($permission_id, $user_id): void
    {
        $user = User::find($user_id);

        if ($user->hasPermissionTo($permission_id)) {
            $user->revokePermissionTo($permission_id);
        } else {
            $user->givePermissionTo($permission_id);
        }

        $this->reset('UserPermission');

        $this->UserPermission = $user->permissions->pluck('name');
    }

    public function update($id): void
    {
        $user = User::find($id);

        if (!empty($this->password)) {
            $user->password = $this->password;
        }

        $user->nombres = $this->nombres;
        $user->paterno = $this->paterno;
        $user->materno = $this->materno;
        $user->dni = $this->dni;
        $user->telefono = $this->telefono;
        $user->email = $this->email;

        $user->save();

        $this->event = 'index';
    }

    public function destroy($id): void
    {
        $user = User::find($id);

        $user->syncPermissions();

        $user->delete();

        $this->event = 'index';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        //buscar

        if (!empty($this->s)) {
            return view(
                'livewire.users',
                ['users' => DB::table('users')
                ->where('nombres', 'LIKE', '%' . $this->s . '%')
                ->orWhere('paterno', 'LIKE', '%' . $this->s . '%')
                ->orWhere('materno', 'LIKE', '%' . $this->s . '%')
                ->orWhere('dni', 'LIKE', '%' . $this->s . '%')
                ->orWhere('email', 'LIKE', '%' . $this->s . '%')
                ->orWhere('telefono', 'LIKE', '%' . $this->s . '%')
                ->join('users_group', 'users_group.id', '=', 'users.id')
                ->select(
                    'users.id as user_id',
                    'users.nombres as nombres',
                    'users.paterno as paterno',
                    'users.materno as materno',
                    'users.dni as dni',
                    'users.telefono as telefono',
                    'users.email as email',
                    'users.created_at as created_at',
                    'users.last_ip as last_ip',
                    'users.is_active as is_active',
                    'users.google2fa_enable as 2FA',
                    'users.last_ip as last_ip',
                    'users_group.grupo as grupo'
                )
                ->paginate(20), ]
            );
        } //index

        return view('livewire.users', ['users' => DB::table('users')
                ->join('users_group', 'users_group.id', '=', 'users.grupo_id')
                ->select(
                    'users.id as user_id',
                    'users.nombres as nombres',
                    'users.paterno as paterno',
                    'users.materno as materno',
                    'users.dni as dni',
                    'users.telefono as telefono',
                    'users.email as email',
                    'users.last_ip as last_ip',
                    'users.is_active as is_active',
                    'users.last_ip as last_ip',
                    'users.google2fa_enable as FA',
                    'users_group.grupo as grupo',
                    'users.created_at as created_at',
                )
                ->paginate(20), ])->extends('layouts.Master')
            ->section('container');
    }
}
