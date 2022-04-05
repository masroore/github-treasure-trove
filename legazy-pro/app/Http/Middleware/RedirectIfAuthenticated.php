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
        if (!$request->secure() && $_SERVER['HTTP_HOST'] != 'localhost' && env('APP_ENV') != 'local') {
            // dd($request->getrequestUri());
            return redirect()->secure($request->getrequestUri());
        }

        if (Auth::guard($guard)->check()) {
            session()->forget('home');
            if (empty($request->referred_id)) {
                return redirect(RouteServiceProvider::HOME);
            }
        } else {
            if (!$request->session()->has('home')) {
                session(['home' => 1]);
                if (empty($request->referred_id)) {
                    return redirect('../home');
                }
            }
            if ($request->getPathInfo = !'login' || $request->getPathInfo = !'register') {
                return redirect('../home');
            }
        }

        return $next($request);
    }
}
