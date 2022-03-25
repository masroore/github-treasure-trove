<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForcelogoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        // Check if user is authenticated

        if (Auth::user()) {
            // code...
            $user = Auth::user()->force_logout;

            if (1 == $user) {
                // dd($request);
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return Redirect()->route('home');
            }

            return $next($request);
        }

        // dd($request);
        return $next($request);
    }
}
