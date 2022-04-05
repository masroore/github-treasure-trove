<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompletedWorkOrder extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $wo;

    /**
     * Create a new message instance.
     */
    public function __construct($wo)
    {
        $this->wo = $wo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.completion');
    }
}
