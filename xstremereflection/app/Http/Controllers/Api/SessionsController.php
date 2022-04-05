<?php

namespace Vanguard\Http\Controllers\Api;

use Vanguard\Http\Resources\SessionResource;
use Vanguard\Repositories\Session\SessionRepository;

/**
 * Class SessionsController.
 */
class SessionsController extends ApiController
{
    /**
     * @var SessionRepository
     */
    private $sessions;

    public function __construct(SessionRepository $sessions)
    {
        $this->middleware('session.database');
        $this->sessions = $sessions;
    }

    /**
     * Get info about specified session.
     *
     * @param $session
     *
     * @return SessionResource
     */
    public function show($session)
    {
        $this->authorize('manage-session', $session);

        return new SessionResource($session);
    }

    /**
     * Destroy specified session.
     *
     * @param $session
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($session)
    {
        $this->authorize('manage-session', $session);

        $this->sessions->invalidateSession($session->id);

        return $this->respondWithSuccess();
    }
}
