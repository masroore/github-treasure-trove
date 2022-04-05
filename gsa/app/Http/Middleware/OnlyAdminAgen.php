<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class OnlyAdminAgen
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
        if ((int) Auth::user()->level == 1 || (int) Auth::user()->level == 3) {
            return $next($request);
        }
        abort(403);
    }
}
