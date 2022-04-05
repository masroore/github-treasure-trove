<?php

namespace Vanguard\Http\Controllers\Api\Users;

use Vanguard\Http\Controllers\Api\ApiController;
use Vanguard\Http\Resources\SessionResource;
use Vanguard\Repositories\Session\SessionRepository;
use Vanguard\User;

class SessionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('permission:users.manage');
        $this->middleware('session.database');
    }

    /**
     * Get sessions for specified user.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(User $user, SessionRepository $sessions)
    {
        return SessionResource::collection(
            $sessions->getUserSessions($user->id)
        );
    }
}
