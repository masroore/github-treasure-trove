<?php

namespace Modules\Setting\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailManager extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $array;

    /**
     * Create a new message instance.
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->array['view'])
            ->from($this->array['from'])
            ->subject($this->array['subject']);
    }
}
