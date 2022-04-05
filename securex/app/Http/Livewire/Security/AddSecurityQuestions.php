<?php

namespace App\Http\Livewire\Security;

use Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

class AddSecurityQuestions extends Component
{
    public $question_1;

    public $question_2;

    public $answer_1;

    public $answer_2;

    public function addQuestions()
    {
        $messages = [
            'question_1.required' => Lang::get('alerts.security.validation.question_1_required'),
            'answer_1.required' => Lang::get('alerts.security.validation.answer_1_required'),
            'question_2.required' => Lang::get('alerts.security.validation.question_2_required'),
            'answer_2.required' => Lang::get('alerts.security.validation.answer_2_required'),
        ];

        $validatedData = $this->validate([
            'question_1' => 'required',
            'answer_1' => 'required',
            'question_2' => 'required',
            'answer_2' => 'required',
        ], $messages);

        $user = Auth::user();

        $user->questions()->create($validatedData);

        $user->security_questions = true;

        $google2fa = new Google2FA();

        $user->two_factor_secret = encrypt($google2fa->generateSecretKey(16));

        $user->save();

        laraflash(Lang::get('alerts.security.questions_added'), Lang::get('alerts.success'))->success();

        return redirect()->route('security.index');
    }

    public function render()
    {
        return view('livewire.security.add-security-questions');
    }
}
