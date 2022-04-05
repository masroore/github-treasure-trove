<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((int) Auth::user()->level !== 1) {
            abort(403);
        }

        return $next($request);
    }
}
