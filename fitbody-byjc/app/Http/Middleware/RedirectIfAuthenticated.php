<?php

namespace App\Http\Middleware;

use Bouncer;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param null|string              $guard
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Bouncer::is(Auth::user())->an('customer')) {
                return redirect()->route('moj');
            }

            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
}
