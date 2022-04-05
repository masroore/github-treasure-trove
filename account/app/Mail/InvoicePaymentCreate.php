<?php

namespace App\Mail;

use App\Utility;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoicePaymentCreate extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $payment;

    /**
     * Create a new message instance.
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ('super admin' == Auth::user()->type) {
            return $this->view('email.invoice_payment_create')->subject('Ragarding to payment succesfully received')->with('payment', $this->payment);
        }

        return $this->from(Utility::getValByName('company_email'), Utility::getValByName('company_email_from_name'))->view('email.invoice_payment_create')->subject('Ragarding to payment succesfully received')->with('payment', $this->payment);
    }
}
