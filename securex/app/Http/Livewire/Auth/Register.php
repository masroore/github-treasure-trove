<?php

namespace App\Http\Livewire\Auth;

use App\Models\Users\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use TechTailor\RPG\Facade\RPG;

class Register extends Component
{
    public $first_name;

    public $last_name;

    public $email;

    public $password;

    public $password_confirmation;

    public $password_hint;

    public $agree;

    public $captcha = 0;

    public function updated($field): void
    {
        $this->validateOnly($field, [
            'email' => 'email|unique:users',
        ]);
    }

    public function register()
    {
        $messages = [
            'first_name.required' => Lang::get('alerts.profile.validation.first_name_required'),
            'last_name.required' => Lang::get('alerts.profile.validation.last_name_required'),
            'email.required' => Lang::get('alerts.profile.validation.email_required'),
            'password.required' => Lang::get('alerts.profile.validation.password_required'),
            'password_confirmation.required' => Lang::get('alerts.profile.validation.password_confirmation_required'),
            'agree.required' => Lang::get('alerts.profile.validation.agree'),
            'captcha.recaptcha' => Lang::get('alerts.profile.validation.captcha_recaptcha'),
        ];

        // Validating Form Input
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'password_hint' => 'nullable|string|max:40',
            'agree' => 'required',
        ], $messages);

        if (setting()->get('recaptcha_enabled') == 'true') {
            $this->validate([
                'captcha' => 'recaptcha',
            ], $messages);
        }

        // Creating the User
        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'password_hint' => $this->password_hint,
            'support_pin' => RPG::Generate('d', 4, 0, 0),
            'access_key' => RPG::Generate('ud', 30, 1, 1),
            'locale' => setting()->get('app_locale'),
            'type' => User::DEFAULT_TYPE,
        ]);

        // Sending Verification Email
        event(new Registered($user));

        // Create the default Personal Vault
        $user->vaults()->create([
            'name' => Lang::get('vault.default_vault_name'),
            'description' => Lang::get('vault.default_vault_description'),
            'icon' => 'hdd',
            'color' => '#000000',
        ]);

        // Loggin in the User
        Auth::login($user);

        // Redirecting to the Dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
