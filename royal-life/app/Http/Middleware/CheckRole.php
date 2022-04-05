<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if ($request->user()->admin == 0) {
            if ($request->getPathInfo() != '/dashboard/admin/settlement/liquidation') {
                abort(403, 'No tienes autorización para ingresar a esta seccion.');
            }
        }

        return $next($request);
    }
}
