<?php

namespace App\Mail;

use App\Utility;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VenderBillSend extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $bill;

    /**
     * Create a new message instance.
     */
    public function __construct($bill)
    {
        $this->bill = $bill;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ('super admin' == Auth::user()->type) {
            return $this->view('email.vender_bill_send')->with('bill', $this->bill)->subject('Ragarding to send bill');
        }

        return $this->from(Utility::getValByName('company_email'), Utility::getValByName('company_email_from_name'))->view('email.vender_bill_send')->with('bill', $this->bill)->subject('Ragarding to send bill');
    }
}
