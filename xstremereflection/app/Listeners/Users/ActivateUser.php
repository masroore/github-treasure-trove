<?php

namespace Vanguard\Listeners\Users;

use Illuminate\Auth\Events\Verified;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\UserStatus;

class ActivateUser
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $this->users->update($event->user->id, [
            'status' => UserStatus::ACTIVE,
        ]);
    }
}
