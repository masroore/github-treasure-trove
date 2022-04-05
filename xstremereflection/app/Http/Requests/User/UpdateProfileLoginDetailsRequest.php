<?php

namespace Vanguard\Http\Requests\User;

use Auth;

class UpdateProfileLoginDetailsRequest extends UpdateLoginDetailsRequest
{
    /**
     * Get authenticated user.
     *
     * @return mixed
     */
    protected function getUserForUpdate()
    {
        return Auth::user();
    }
}
