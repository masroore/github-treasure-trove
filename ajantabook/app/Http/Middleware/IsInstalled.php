<?php

namespace App\Http\Middleware;

use Closure;

class IsInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        $isInstall = env('IS_INSTALLED');

        if (1 == $isInstall) {
            return $next($request);
        }

        return redirect()->route('eulaterm');
    }
}
