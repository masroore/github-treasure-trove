<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null              $guard
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ('admin' == $guard && auth($guard)->check()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
