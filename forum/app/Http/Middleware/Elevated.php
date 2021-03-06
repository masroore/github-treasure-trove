<?php

namespace App\Http\Middleware;

use Closure;

class Elevated
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
        if ($request->user()->isElevated()) {
            return $next($request);
        }

        return redirect()->route('home.index');
    }
}
