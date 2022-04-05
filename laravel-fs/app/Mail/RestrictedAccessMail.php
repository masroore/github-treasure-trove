<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestrictedAccessMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * AQUI SE CAPTURAN TODOS LOS DATOS QUE SE QUIEREN ENVIAR.
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $info = $this->data['info_mail'];

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view($this->data['template'], compact('info'))
            ->subject(__('FirstSwitch restricted access'));
    }
}
