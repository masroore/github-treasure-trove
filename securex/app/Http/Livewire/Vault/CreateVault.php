<?php

namespace App\Http\Livewire\Vault;

use App\Mail\Alerts\VaultLimitReached as VaultLimitReachedMail;
use App\Notifications\User\VaultLimitReached;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreateVault extends Component
{
    public $name;

    public $description;

    public $icon = 'sun';

    public $color = '#000000';

    public $password;

    public $hashedpass;

    public function createVault(): void
    {
        $messages = [
            'name.required' => Lang::get('alerts.vault.validation.name_required'),
            'name.min' => Lang::get('alerts.vault.validation.name_min'),
            'name.max' => Lang::get('alerts.vault.validation.name_max'),
            'name.string' => Lang::get('alerts.vault.validation.name_string'),
            'description.required' => Lang::get('alerts.vault.validation.description_required'),
            'description.min' => Lang::get('alerts.vault.validation.description_min'),
            'description.max' => Lang::get('alerts.vault.validation.description_max'),
            'icon.required' => Lang::get('alerts.vault.validation.icon_required'),
            'color.required' => Lang::get('alerts.vault.validation.color_required'),
            'password.min' => Lang::get('alerts.vault.validation.password_min'),
        ];

        $this->validate([
            'name' => 'required|string|min:3|max:14',
            'description' => 'required|string|min:5|max:245',
            'icon' => 'required',
            'color' => 'required',
            'password' => 'nullable|string|min:4',
        ], $messages);

        $this->storeVault();
    }

    public function storeVault()
    {
        $hashedpass = null;

        if ($this->password) {
            $hashedpass = Hash::make($this->password);
        }

        $user = Auth::user();
        $vault = $user->vaults()->create([
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
            'password' => $hashedpass,
        ]);

        if ($user->hasReachedVaultLimit()) {
            $user->notify(new VaultLimitReached());
            if (setting()->get('app_email_alerts') === 'true') {
                Mail::to($user->email)->send(new VaultLimitReachedMail($user));
            }
        }

        laraflash($vault->name . ' - ' . Lang::get('alerts.vault.created'), Lang::get('alerts.success'))->success();

        return redirect()->route('vaults');
    }

    public function render()
    {
        return view('livewire.vault.create-vault');
    }
}
