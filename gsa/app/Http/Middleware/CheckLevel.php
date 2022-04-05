<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckLevel
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
        if (Auth::user()->level != 1) {
            return 'unauthorized';
        }

        return $next($request);
    }
}
