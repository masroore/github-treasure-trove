<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 14.02.19
 * Time: 15:12.
 */

namespace App\Helpers\Menu;

use App\Models\Menu\MenuItem;

abstract class MenuItemSuffix
{
    abstract public function get(MenuItem $menuItem): string;
}
