<?php

namespace App\Http\Middleware;

use App\Services\TeamService;
use Closure;

class Update
{
    public function __construct(
        TeamService $teamService
    ) {
        $this->teamService = $teamService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $me = auth()->user();
        if ($me->version < 2) {
            $this->teamService->createPrivate($me);
            $me->version = 2;
            $me->save();
        }

        return $next($request);
    }
}
