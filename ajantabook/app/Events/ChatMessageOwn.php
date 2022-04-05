<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageOwn implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $data;

    public $conv_id;

    public $sender_id;

    /**
     * Create a new event instance.
     */
    public function __construct($data, $conv_id, $sender_id)
    {
        $this->data = $data;
        $this->conv_id = $conv_id;
        $this->sender_id = $sender_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return ['chat-msg-own'];
    }

    public function broadcastAs()
    {
        return 'conversation_own_' . $this->conv_id . '_user_' . $this->sender_id;
    }
}
