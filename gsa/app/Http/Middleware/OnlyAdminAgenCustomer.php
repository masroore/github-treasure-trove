<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class OnlyAdminAgenCustomer
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
        if ((int) Auth::user()->level == 1 || (int) Auth::user()->level == 3 || (int) Auth::user()->level == 2) {
            return $next($request);
        }
        abort(403);
    }
}
