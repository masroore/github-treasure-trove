<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalanceLoaded extends Mailable
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
        return $this->view('emails.top_up')
            ->subject('Balance Top Up')
            ->with(['agent' => $this->agent, 'transaction' => $this->transaction]);
    }
}
