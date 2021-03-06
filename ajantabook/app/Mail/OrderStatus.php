<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatus extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $inv;

    public $status;

    public $inv_cus;

    /**
     * Create a new message instance.
     */
    public function __construct($inv_cus, $inv, $status)
    {
        $this->inv_cus = $inv_cus;
        $this->inv = $inv;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.orderstatus')->subject('Order #' . $this->inv_cus->order_prefix . $this->inv->order->order_id . ' status');
    }
}
