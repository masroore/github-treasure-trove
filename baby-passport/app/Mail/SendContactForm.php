<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContactForm extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $name;

    public $phone;

    public $email;

    public $pregnancyWeek;

    public $theme;

    public $question;

    /**
     * Create a new message instance.
     */
    public function __construct($mailBody)
    {
        $this->name = $mailBody['name'];
        $this->phone = $mailBody['phone'];
        $this->email = $mailBody['email'];
        $this->pregnancyWeek = $mailBody['pregnancy_week'];
        $this->theme = $mailBody['theme'];
        $this->question = $mailBody['question'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Baby Passport - Formulario de contacto')
            ->from([
                'name' => $this->email,
            ])
            ->to('babypassport@medicalmeeting.co')
            ->text('emails.contact-form');
    }
}
