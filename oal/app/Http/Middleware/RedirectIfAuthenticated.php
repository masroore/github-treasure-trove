<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            //return redirect(RouteServiceProvider::HOME);

            $user = \Auth::user();
            if ($user->hasRole('Admin')) {
                return redirect('/dashboard');
            } elseif ($user->hasRole(['Invester'])) {
                return redirect('/investor/dashboard');
            }

            return redirect('/denied');
        }

        return $next($request);
    }
}
