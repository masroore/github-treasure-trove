<?php

namespace App\Http\Middleware;

use App\Personalinfo;
use Closure;

class AdmisssionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        $id = $request->session()->get('id');
        if (null === $id) {
            return Redirect()->route('online-admission-login');
        }
        $perinfo = Personalinfo::where('osncode_id', $id)->first();
        if ($perinfo) {
            $status = $perinfo->status;
            if ($status) {
                return Redirect()->route('admission-completed');
            }

            return $next($request);
        }

        return $next($request);
    }
}
