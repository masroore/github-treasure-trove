<?php

namespace App\Http\Middleware;

use Bouncer;
use Closure;

class GiveEditorStrike
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (Bouncer::is(auth()->user())->an('editor')) {
            return abort(401);
        }

        return $next($request);
    }
}
