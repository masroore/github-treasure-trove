<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Sendosncode extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $osncode;

    /**
     * Create a new message instance.
     */
    public function __construct($osncode)
    {
        $this->osncode = $osncode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@amtabiz.com')
            ->view('Mail_Template.osn_code_mail');
    }
}
