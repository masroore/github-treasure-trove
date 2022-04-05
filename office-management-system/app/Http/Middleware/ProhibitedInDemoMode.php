<?php

namespace App\Http\Middleware;

use Closure;
use Toastr;

class ProhibitedInDemoMode
{
    /**
     * Restric action if test mode is turned on.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_SYNC')) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Restricted in demo mode'], 422);
            }

            Toastr::error('Restricted in demo mode');

            return back();
        }

        return $next($request);
    }
}
