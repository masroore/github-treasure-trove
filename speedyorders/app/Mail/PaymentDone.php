<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentDone extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $agent;

    private $transaction;

    /**
     * BalanceLoaded constructor.
     *
     * @param $agent
     * @param $transaction
     */
    public function __construct($agent, $transaction)
    {
        $this->agent = $agent;
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.payment')
            ->subject('Ticket Payment')
            ->with(['agent' => $this->agent, 'transaction' => $this->transaction]);
    }
}
