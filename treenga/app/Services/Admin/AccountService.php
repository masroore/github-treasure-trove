<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\User\Account as UserAccountResourse;

class AccountService
{
    public function account()
    {
        $me = auth()->user();

        return response()->result(new UserAccountResourse($me));
    }
}
