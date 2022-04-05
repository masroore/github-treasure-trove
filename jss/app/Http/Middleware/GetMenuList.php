<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Session;

class GetMenuList
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if(Session::get('menusList') == null) {
        $tbl = new Menu();
        $menus = $tbl->getMenuList();

        Session::put('menusList', $menus);
        // }

        return $next($request);
    }
}
