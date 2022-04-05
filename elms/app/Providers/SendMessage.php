<?php

namespace App\Providers;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $recipients;

    public $uid;

    /**
     * Create a new event instance.
     */
    public function __construct($recipients, $uid)
    {
        $this->recipients = $recipients;
        $this->uid = $uid;
    }
}
