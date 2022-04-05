<?php

namespace App\Http\Middleware;

use App\Genral;
use Auth;
use Closure;
use Exception;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        try {
            $setting = Genral::select('email_verify_enable')->first();
        } catch (Exception $e) {
        }

        if (Auth::check()) {
            if ('1' == $setting->email_verify_enable) {
                if (null == Auth::user()->email_verified_at) {
                    return redirect()->route('verification.notice');
                }
            }

            return $next($request);
        }

        return $next($request);
    }
}
