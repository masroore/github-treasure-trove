<?php

namespace Vanguard\Listeners\Users;

use Vanguard\Events\User\Banned;
use Vanguard\Repositories\Session\SessionRepository;

class InvalidateSessions
{
    /**
     * @var SessionRepository
     */
    private $sessions;

    public function __construct(SessionRepository $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * Handle the event.
     */
    public function handle(Banned $event): void
    {
        $user = $event->getBannedUser();

        $this->sessions->invalidateAllSessionsForUser($user->id);
    }
}
