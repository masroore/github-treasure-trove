<?php

namespace App\Http\Middleware;

use Auth;

use Closure;
use Illuminate\Support\Facades\Config;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth::check()) {
            $admin_list = (['User']);
            $user_role = Auth::user()->getRoleNames()
                ->first();

            if (in_array($user_role, $admin_list) && Auth::user()->status == 1) {
                return $next($request);
            }

            Auth::logout();

            return redirect()->route('login')
                ->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.ACCOUNT_ISSUE'));

            return $next($request);
        }

        Auth::logout();

        return redirect()->route('login')
            ->with('status', 'error')
            ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
    }
}
