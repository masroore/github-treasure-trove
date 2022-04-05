<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\Login as AuthLoginRequest;
use App\Services\Admin\AccountService;
use App\Services\Admin\AuthService;

class AuthController extends Controller
{
    protected $authService;

    protected $accountService;

    public function __construct(AuthService $authService, AccountService $accountService)
    {
        $this->authService = $authService;
        $this->accountService = $accountService;
    }

    public function login(AuthLoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function account()
    {
        return $this->accountService->account();
    }
}
