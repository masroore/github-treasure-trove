<?php

namespace App\Http\Middleware;

use App\Maintainence;
use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Schema;

class MaintainenceMode
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (DB::connection()->getDatabaseName()) {
            if (Schema::hasTable('table_maintainence_mode')) {
                $row = Maintainence::first();

                if (isset($row) && 1 == $row->status && !empty($row->allowed_ips) && !\in_array($request->ip(), $row->allowed_ips)) {
                    if (Auth::check() && auth()->user()->getRoleNames()->contains('Super Admin')) {
                        return $next($request);
                    }

                    return Response(view('maintain', compact('row')));
                }

                return $next($request);
            }
        }

        return $next($request);
    }
}
