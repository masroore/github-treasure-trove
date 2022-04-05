<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\Users\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use TechTailor\RPG\Facade\RPG;

class AddNewUser extends Component
{
    public $first_name;

    public $last_name;

    public $email;

    public function updated($field): void
    {
        $this->validateOnly($field, [
            'email' => 'unique:users',
        ]);
    }

    public function addUser()
    {
        $messages = [
            'email.required' => Lang::get('alerts.admin.users.validation.email_required'),
            'first_name.required' => Lang::get('alerts.admin.users.validation.first_name_required'),
        ];

        $this->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'nullable|max:100',
            'email' => 'required|email|unique:users',
        ], $messages);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->email),
            'support_pin' => RPG::Generate('d', 4, 0, 0),
            'access_key' => RPG::Generate('ud', 30, 1, 1),
            'locale' => setting()->get('app_locale'),
            'type' => User::DEFAULT_TYPE,
        ]);

        event(new Registered($user));

        // Create the default Personal Vault
        $user->vaults()->create([
            'name' => 'Personal',
            'description' => 'Your default vault for storing items.',
            'icon' => 'hdd',
            'color' => '#000000',
        ]);

        laraflash(Lang::get('alerts.admin.users.added_success'), Lang::get('alerts.success'))->success();

        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.add-new-user');
    }
}
