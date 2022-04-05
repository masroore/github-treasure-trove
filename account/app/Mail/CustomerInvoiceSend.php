<?php

namespace App\Mail;

use App\Utility;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerInvoiceSend extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ('super admin' == Auth::user()->type) {
            return $this->view('email.customer_invoice_send')->with('invoice', $this->invoice)->subject('Ragarding to send invoice');
        }

        return $this->from(Utility::getValByName('company_email'), Utility::getValByName('company_email_from_name'))->view('email.customer_invoice_send')->with('invoice', $this->invoice)->subject('Ragarding to send invoice');
    }
}
