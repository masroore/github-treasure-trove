<?php

namespace Modules\ExternalShop\Events;

use Illuminate\Queue\SerializesModels;
use Modules\ExternalShop\Entities\Order;

class OrderCreated
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
