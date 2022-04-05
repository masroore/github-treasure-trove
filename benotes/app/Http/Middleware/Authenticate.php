<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (in_array('share', $guards) && $this->auth->guard('share')->check()) {
            config()->set('auth.defaults.guard', 'share');

            return $next($request);
        } elseif ($this->auth->guard('api')->check()) {
            return $next($request);
        } elseif ($this->auth->guard()->guest()) {
            return response()->json('Unauthorized.', 401);
        }
    }
}
