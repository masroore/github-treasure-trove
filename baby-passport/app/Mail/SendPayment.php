<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPayment extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $email;

    public $payDate;

    public $paymentId;

    public $authCode;

    public $concept;

    public $price;

    public $cardType;

    public $cardNumber;

    public $holderName;

    public $receipt;

    /**
     * Create a new message instance.
     */
    public function __construct($mailBody)
    {
        $this->email = $mailBody['email'];
        $this->payDate = $mailBody['payDate'];
        $this->paymentId = $mailBody['paymentId'];
        $this->authCode = $mailBody['authCode'];
        $this->concept = $mailBody['concept'];
        $this->price = $mailBody['price'];
        $this->cardType = $mailBody['cardType'];
        $this->holderName = $mailBody['holderName'];
        $this->cardNumber = $mailBody['cardNumber'];
        $this->receipt = $mailBody['receipt'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Baby Passport - Recibo de Compra')
            ->to($this->email)
            ->attach($this->receipt)
            ->view('emails.receipt');
    }
}
