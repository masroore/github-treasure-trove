<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 27.01.19
 * Time: 11:51.
 */

namespace App\Http\View\FrontComposers;

use App\Models\Menu\MenuItem;
use Cache;
use Illuminate\View\View;
use UrlAliasLocalization;

class MenusComposer
{
    protected $data;

    public function compose(View $view): void
    {
        if ($this->data === null) {
            $data = Cache::remember('front_menus' . UrlAliasLocalization::getCurrentLocale(), 10, function () { // TODO cache name
                $menu_items_main_menu = MenuItem::byMenu('main_menu')->get()->toTree(); // TODO dynamic
                $menu_items_social_network = MenuItem::byMenu('social_networks')->with('media')->get();
                $menu_for_clients = MenuItem::byMenu('for_clients')->get();

                return compact('menu_items_main_menu', 'menu_items_social_network', 'menu_for_clients');
            });

            $this->data = $data;
        }

        $view->with($this->data);
    }
}
