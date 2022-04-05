<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ('1' == auth()->user()->google2fa_enable) {
                if (1 == Cookie::get('two_fa')) {
                    return $next($request);
                }
                require base_path() . '/app/Http/Controllers/price.php';

                return Response(view('front.2fa.otp', compact('conversion_rate')));
            }

            return $next($request);
        }

        return $next($request);
    }
}
