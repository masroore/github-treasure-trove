<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (!auth()->user()->getRoleNames()->contains('Seller') && !auth()->user()->getRoleNames()->contains('Customer') && !auth()->user()->getRoleNames()->contains('Blocked')) {
                return $next($request);
            }

            notify()->error('Access denied !');

            return redirect(route('login'));
        }

        return redirect(route('login'));
    }
}
