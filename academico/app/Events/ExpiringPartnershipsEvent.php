<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpiringPartnershipsEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $partners;

    public function __construct($partners)
    {
        $this->partners = $partners;
    }
}
