<?php

namespace App\Http\Middleware;

use App\Traits\SendResponseTrait;
use Closure;
use Exception;
use JWTAuth;

class JwtMiddleware
{
    use SendResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->apiResponse('error', 404, 'Token is Invalid');
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->apiResponse('error', 404, 'Token is Expired');
            } elseif ($e instanceof Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                return $this->apiResponse('error', 405, 'Method is not allowed');
            }

            return $this->apiResponse('error', 404, 'Authorization Token not found');
        }

        return $next($request);
    }
}
