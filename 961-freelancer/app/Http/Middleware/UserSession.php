<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->exists('u_session')) {
            return $next($request);
        }

        return redirect('/login');
    }
}
