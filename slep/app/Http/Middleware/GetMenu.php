<?php

namespace App\Http\Middleware;

use App;
use App\Http\Menus\GetSidebarMenu;
use App\Models\MenuLangList;
use App\Models\Menulist;
use App\Models\RoleHierarchy;
use Closure;
use Illuminate\Support\Facades\Auth;

class GetMenu
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
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        if (Auth::check()) {
            $role = 'guest';
            //$role =  Auth::user()->menuroles;
            $userRoles = Auth::user()->getRoleNames();
            //$userRoles = $userRoles['items'];
            $roleHierarchy = RoleHierarchy::select('role_hierarchy.role_id', 'roles.name')
                ->join('roles', 'roles.id', '=', 'role_hierarchy.role_id')
                ->orderBy('role_hierarchy.hierarchy', 'asc')->get();
            $flag = false;
            foreach ($roleHierarchy as $roleHier) {
                foreach ($userRoles as $userRole) {
                    if ($userRole == $roleHier['name']) {
                        $role = $userRole;
                        $flag = true;

                        break;
                    }
                }
                if ($flag === true) {
                    break;
                }
            }
        } else {
            $role = 'guest';
        }
        $menus = new GetSidebarMenu();
        $menulists = Menulist::all();
        $result = [];
        foreach ($menulists as $menulist) {
            $result[$menulist->name] = $menus->get($role, App::getLocale(), $menulist->id);
        }
        view()->share('appMenus', $result);
        view()->share('locales', MenuLangList::all());
        view()->share('appLocale', App::getLocale());

        return $next($request);
    }
}
