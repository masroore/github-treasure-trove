<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The demo object instance.
     *
     * @var PasswordEmail
     */
    public $p_email;

    /**
     * Create a new message instance.
     */
    public function __construct($p_email)
    {
        $this->p_email = $p_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@valdusoft.com')
            ->view('auth.passwords.email-send')
            ->text('mails.demo_plain')
            ->with(
                [
                    'testVarOne' => '1',
                    'testVarTwo' => '2',
                ]
            )
            ->attach(public_path('/images') . '/demo.jpg', [
                'as' => 'demo.jpg',
                'mime' => 'image/jpeg',
            ]);
    }
}
