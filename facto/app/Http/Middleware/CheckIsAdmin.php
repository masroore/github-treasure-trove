<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdmin
{
    public function handle($request, Closure $next)
    {
        $allowed_roles = ['admin'];
        if (!Auth::check()) {
            notify()->error('로그인이 필요합니다.');

            return redirect('/');
        }

        $role = Auth::user()->role->name;
        // dd($role_name);
        if (in_array($role, $allowed_roles)) {
            return $next($request);
        }

        notify()->error('권한이 없습니다.');

        return redirect('/');
    }
}
