<?php

namespace App\Http\Middleware;

use Closure;

class Google2FA
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
        $response = $next($request);

        if ((setting()->get('tfa_enabled') == 'true') && (auth()->user()->two_factor_enabled) && (!$request->session()->has('two_factor_authenticated'))) {
            return response()->view('auth.2fa');
        }

        return $response;
    }
}
