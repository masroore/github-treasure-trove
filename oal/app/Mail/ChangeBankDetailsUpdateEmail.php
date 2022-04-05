<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ChangeBankDetailsUpdateEmail extends Mailable
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
            ->subject('Your bank details change request has been approved & updated')
            ->markdown('emails.changeBankDetailsUpdateEmail');
    }
}
