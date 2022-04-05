<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (setting()->get('force_https') && !$request->secure() && app()->environment('production')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
