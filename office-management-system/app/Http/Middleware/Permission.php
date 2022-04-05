<?php

namespace App\Http\Middleware;

use Closure;

class Permission
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
        if (auth()->user()->role->type == 'system_user') {
            return $next($request);
        }

        $roles = app('permission_list');
        $role = $roles->where('id', auth()->user()->role_id)->first();

        if ('.create' == substr($request->route()->getName(), -7)) {
            if ($role != null && $role->permissions->contains('route', str_replace('.create', '.store', $request->route()->getName()))) {
                return $next($request);
            }
            abort(401);
        }
        if ('.update' == substr($request->route()->getName(), -7)) {
            if ($role != null && $role->permissions->contains('route', str_replace('.update', '.edit', $request->route()->getName()))) {
                return $next($request);
            }
            abort(401);
        } else {
            if ($role != null && $role->permissions->contains('route', $request->route()->getName())) {
                return $next($request);
            }
            abort(401);
        }
    }
}
