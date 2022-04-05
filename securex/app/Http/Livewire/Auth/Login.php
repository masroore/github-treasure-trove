<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public $email;

    public $password;

    public $remember;

    public function updated($field): void
    {
        $this->validateOnly($field, [
            'email' => 'email|exists:users',
        ]);
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string',
            'remember' => 'nullable',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Authentication passed...
            $user = Auth::user();

            if ($user->status == 'Active') {
                return redirect()->intended('dashboard');
            }

            $remark = $user->remark;
            Session::flush();
            Auth::logout();
            session()->flash('banned', $remark);

            return redirect()->route('login');
        }

        return $this->addError('password', Lang::get('alerts.profile.validation.master_password_password'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
