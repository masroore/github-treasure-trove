<?php

namespace App\Http\Middleware;

use Bouncer;
use Closure;

class RedirectIfCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (Bouncer::is(auth()->user())->an('customer')) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
