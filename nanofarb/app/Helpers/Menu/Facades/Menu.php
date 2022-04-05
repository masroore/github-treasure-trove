<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 10.02.19
 * Time: 23:00.
 */

namespace App\Helpers\Menu\Facades;

use Illuminate\Support\Facades\Facade;

class Menu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Helpers\Menu\Menu::class;
    }
}
