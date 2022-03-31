<?php

namespace Modules\AdminRbac\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\AdminRbac\Utils\Permission;

class CheckIfUserHasPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $module)
    {
        if (!Permission::check($module)) {
            session()->flash('error_message', 'You do not have permission to perform requested action.');

            return back();
        }

        return $next($request);
    }
}
