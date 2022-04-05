<?php

namespace App\Http\Controllers\Api\Auth\Traits;

trait CheckLoginType
{
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username($login)
    {
        return filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    }
}
