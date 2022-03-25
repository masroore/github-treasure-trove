<?php

namespace App\Mail;

use App\Utility;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalSend extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $proposal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ('super admin' == \Auth::user()->type) {
            return $this->view('email.proposal_send')->with('proposal', $this->proposal)->subject('Ragarding to product/service proposal generator.');
        }

        return $this->from(Utility::getValByName('company_email'), Utility::getValByName('company_email_from_name'))->view('email.proposal_send')->with('proposal', $this->proposal)->subject('Ragarding to product/service proposal generator.');
    }
}
