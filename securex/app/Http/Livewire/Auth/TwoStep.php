<?php

namespace App\Http\Livewire\Auth;

use Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class TwoStep extends Component
{
    public $otp;

    public function authenticateCode()
    {
        $messages = [
            'otp.required' => Lang::get('alerts.security.validation.otp_required'),
            'otp.digits' => Lang::get('alerts.security.validation.otp_digits'),
        ];

        $this->validate([
            'otp' => 'required|numeric|digits:6',
        ], $messages);

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(decrypt(Auth::user()->two_factor_secret), $this->otp, 8);

        if ($valid) {
            session()->put('two_factor_authenticated', time());

            return redirect()->route('dashboard');
        }

        return $this->addError('otp', Lang::get('alerts.security.validation.otp_invalid'));
    }

    public function render()
    {
        return view('livewire.auth.twostep');
    }
}
