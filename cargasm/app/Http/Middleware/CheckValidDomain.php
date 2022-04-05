<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Response;

class CheckValidDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
//    public function handle($request, Closure $next)
//    {
//        if ($request->isMethod('get') === false) {
//            return  $next($request);
//        }
//
//        if (Domain::checkValidDomain(request()->header('client'))) {
//            return $next($request);
//        }
//
//        return response()->json(['message' => trans('system.domain.error')], Response::HTTP_BAD_REQUEST);
//    }
}
