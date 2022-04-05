<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class BankSlipConfirmEmail extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $from_email = config('settings.from_email');
        $from_name = config('settings.from_name');

        return $this
            ->from($from_email, $from_name)
            ->subject('Bank in slip accepted')
            ->markdown('emails.bankSlipConfirmEmail');
    }
}
