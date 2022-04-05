<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WarningSend extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $warning;

    /**
     * Create a new message instance.
     */
    public function __construct($warning)
    {
        $this->warning = $warning;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.warning_send')->with('warning', $this->warning)->subject('Ragarding to warning letter.');
    }
}
