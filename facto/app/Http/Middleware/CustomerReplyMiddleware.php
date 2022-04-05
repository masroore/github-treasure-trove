<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerReplyMiddleware
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return $next($request);
            }
        }

        $customer_id = $request->route('customer');

        $key = 'customer-reply-' . $customer_id;
        $saved_session = $request->session()->get($key);
        if ($saved_session == 'success') {
            return $next($request);
        }

        return false;
    }
}
