<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $neworder;

    public $inv_cus;

    public $paidcurrency;

    /**
     * Create a new message instance.
     */
    public function __construct($neworder, $inv_cus, $paidcurrency)
    {
        $this->neworder = $neworder;
        $this->inv_cus = $inv_cus;
        $this->paidcurrency = $paidcurrency;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.ordermail')->subject('Order #' . $this->inv_cus->order_prefix . $this->neworder->order_id . ' Placed Successfully !');
    }
}
