<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;

class Created
{
    use SerializesModels;

    public $user;

    public $rawPassword;

    /**
     * Create a new event instance.
     */
    public function __construct($user, $rawPassword)
    {
        $this->user = $user;

        $this->rawPassword = $rawPassword;
    }
}
