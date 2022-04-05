<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

use Vanguard\Customer;

class AcceptedEstimateEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $estimate;

    /**
     * Create a new message instance.
     */
    public function __construct($estimate)
    {
        $this->estimate = $estimate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $customer = Customer::find($this->estimate->customerId);
        view()->share('customer', $customer);
        view()->share('estimate', $this->estimate);
        $pdf = PDF::loadView('estimate.pdf.estimate')->setOption('footer-right', 'Page [page] from [topage]');

        $file = $customer->lastName . '_' . $this->estimate->id . '_estimate.pdf';

        return $this->view('emails.estimateAccepted')->attachData($pdf->output(), $file);
    }
}
