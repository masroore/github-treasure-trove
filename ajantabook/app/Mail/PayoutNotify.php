<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayoutNotify extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $msg;

    public $currency;

    public $amount;

    public $type;

    /**
     * Create a new message instance.
     */
    public function __construct($msg, $currency, $amount, $type)
    {
        $this->msg = $msg;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.payout')->subject('You recived a new Payout !');
    }
}
