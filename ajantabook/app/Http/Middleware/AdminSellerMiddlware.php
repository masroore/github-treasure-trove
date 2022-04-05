<?php

namespace App\Http\Middleware;

use Closure;

class AdminSellerMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->getRoleNames()->contains('Customer') && !auth()->user()->getRoleNames()->contains('Blocked')) {
            return $next($request);
        }

        return abort('401', 'Unauthorized action');
    }
}
