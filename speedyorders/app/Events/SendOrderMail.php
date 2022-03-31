<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendOrderMail
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $pdf;
    public $email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pdf, $email)
    {
        $this->pdf = $pdf;
        $this->email = $email;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
