<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Auth2FA
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Si no esta logueado y no existe cookie 2FA

        if (!Auth::check() && empty($_COOKIE['2FA-TOKEN'])) {
            return redirect()->route('init');
        }

        //Si existe cookie 2FA

        if (!empty($_COOKIE['2FA-TOKEN'])) {
            $decryptoUserID = Crypt::decryptString($_COOKIE['2FA-TOKEN']);

            if ($decryptoUserID == auth()->user()->id) {
                return $next($request);
            }
        }

        Auth::logout();

        return redirect()->route('init');
    }
}
