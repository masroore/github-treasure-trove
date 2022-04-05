<?php

namespace App\Http\Livewire\Security;

use App\Mail\Alerts\DiabledTwoStepWithoutPhone;
use App\Notifications\User\TSADisabledWithoutPhone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class DisableTwoStepWithoutPhone extends Component
{
    public $questions;

    public $password;

    public $access_key;

    public $answer_1;

    public $answer_2;

    public function mount(): void
    {
        $questions = Auth::user()->questions;
        $this->questions = $questions;
    }

    public function verifyKeys()
    {
        $messages = [
            'password.required' => Lang::get('alerts.security.validation.password_required'),
            'access_key.required' => Lang::get('alerts.security.validation.access_key_required'),
            'access_key.size' => Lang::get('alerts.security.validation.access_key_size'),
            'answer_1.required' => Lang::get('alerts.security.validation.answer_1_required'),
            'answer_2.required' => Lang::get('alerts.security.validation.answer_2_required'),
        ];

        $this->validate([
            'password' => 'required',
            'access_key' => 'required|alpha_dash|size:35',
            'answer_1' => 'required',
            'answer_2' => 'required',
        ], $messages);

        $user = Auth::user();

        if (!Hash::check($this->password, $user->password)) {
            return $this->addError('password', Lang::get('alerts.profile.validation.master_password_password'));
        }

        $key = decrypt($user->access_key);

        if ($key != $this->access_key) {
            return $this->addError('access_key', Lang::get('alerts.security.validation.access_key_invalid'));
        }

        if ($user->questions->answer_1 != $this->answer_1) {
            return $this->addError('answer_1', Lang::get('alerts.security.validation.answer_1_invalid'));
        }

        if ($user->questions->answer_2 != $this->answer_2) {
            return $this->addError('answer_2', Lang::get('alerts.security.validation.answer_2_invalid'));
        }

        $user->two_factor_enabled = false;
        $user->save();
        $user->notify(new TSADisabledWithoutPhone());
        Mail::to($user->email)->send(new DiabledTwoStepWithoutPhone($user));
        session()->invalidate();
        laraflash(Lang::get('alerts.security.two_step_disabled'), Lang::get('alerts.success'))->success();

        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.security.disable-two-step-without-phone');
    }
}
