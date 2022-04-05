<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 10.02.19
 * Time: 22:59.
 */

namespace App\Helpers\Menu;

use App\Models\Menu\MenuItem;
use Auth;
use Exception;
use Illuminate\Support\Facades\Request;
use Log;

class Menu
{
    protected $app;

    protected $config;

    /**
     * Menu constructor.
     */
    public function __construct($app = null)
    {
        if (!$app) {
            $app = app();   //Fallback when $app is not given
        }
        $this->app = $app;

        $this->config = $this->app['config']->get('menu');
    }

    public function render($menuSystemName)
    {
        // TODO
        if ($menu = \App\Models\Menu\Menu::where('system_name', $menuSystemName)->first()) {
            $menuItemsTree = \App\Models\Menu\MenuItem::byMenu($menuSystemName)->get()->toTree();
            $template = $menu->data['template'] ?? $menu->system_name;

            $blade = $this->config[$template] ?? '';

            return view()->first([$blade, 'menu::default'], compact('menu', 'menuItemsTree'))->render();
        }

        return '';
    }

    /**
     * @return bool|false|int
     */
    public function isActive(MenuItem $item): bool
    {
        if (!empty($item->data['pattern_url'])) {
            $pattern = (trim($item->data['pattern_url'], '/'));

            try {
                return preg_match("/$pattern/", Request::fullUrl());
            } catch (Exception $e) {
                Log::error(__METHOD__ . ' Menu-item active url pattern is not correct!');
            }
        }

        if ($item->getUrl() && ($pattern = trim($item->getUrl(), '/'))) {
            return strpos(Request::url(), $pattern) !== false;
        }

        return false;
    }

    public function isTreeviewOpen(MenuItem $item): bool
    {
        foreach ($item->descendants as $descendant) {
            if ($this->isActive($descendant)) {
                return true;
            }
        }

        return false;
    }

    public function hasAccessToItem(MenuItem $item): bool
    {
        if (Auth::check() && ($user = Auth::user())) {
            if ($user->hasRole('admin')) { // use spatie/laravel-permission
                return true;
            }

            if (isset($item->data['permissions'])) {
                $permissions = is_array($item->data['permissions']) ? $item->data['permissions'] : [$item->data['permissions']];

                if (count($permissions)) {
                    return $user->hasAnyPermission($permissions); // use spatie/laravel-permission
                }
            }
        }

        return false;
    }

    public function hasAccessToTreeview(MenuItem $item): bool
    {
        if (auth()->check() && ($user = auth()->user())) {
            if ($user->hasRole('admin')) {
                return true;
            }

            if (!empty($item->data['permissions']) || !empty($item->data['roles'])) {
                if ($this->hasAccessToItem($item)) {
                    return true;
                }
            }

            foreach ($item->descendants as $descendant) {
                if ($this->hasAccessToItem($descendant)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function suffix(MenuItem $item): string
    {
        $suffixes = $this->config['suffixes'];

        $suffix = $item->suffix ?? $item->name;

        if ($suffix && isset($suffixes[$suffix]) && class_exists($suffixes[$suffix])) {
            return app()->make($suffixes[$suffix])->get($item);
        }

        return '';
    }
}
