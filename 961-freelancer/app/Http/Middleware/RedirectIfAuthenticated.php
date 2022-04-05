<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param null|string ...$guards
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ('web' == $guard) {
                    return redirect(RouteServiceProvider::HOME);
                }
                if ('admin' == $guard) {
                    return redirect(RouteServiceProvider::ADMIN);
                }
            }
        }

        return $next($request);
    }
}
