<?php

namespace App\Events\Form;

use App\Models\Form;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $form;

    /**
     * Create a new event instance.
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }
}
