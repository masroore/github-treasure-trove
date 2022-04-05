<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($request->ajax()) {
                return response()->json([
                    //'message' => trans('notifications.operation.success'),
                    'action' => 'redirect',
                    'destination' => url('/'),
                ]);
            }

            return redirect('/');
        }

        return $next($request);
    }
}
