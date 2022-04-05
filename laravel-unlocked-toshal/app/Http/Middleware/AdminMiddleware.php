<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminMiddleware
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
        if (auth::check()) {
            $admin_list = (['Administrator']);
            $user_role = Auth::user()->getRoleNames()->first();
            if (in_array($user_role, $admin_list) && Auth::user()->status == 1) {
                return $next($request);
            }

            Auth::logout();
            if ($request->ajax()) { // This is what i am needing.
                return response()->json(['error' => 'error', 'message' => 'Session timeout'], 302);
            }

            return redirect()->route('admin');
        }

        Auth::logout();
        if ($request->ajax()) { // This is what i am needing.
            return response()->json(['error' => 'error', 'message' => 'Session timeout'], 302);
        }

        return redirect()->route('admin');
    }
}
