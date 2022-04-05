<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTechEnrouteMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $workOrder;

    /**
     * Create a new message instance.
     */
    public function __construct($workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tech is on their way.')->view('emails.techenroute');
    }
}
