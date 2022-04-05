<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 14.02.19
 * Time: 15:14.
 */

namespace App\Helpers\Menu;

use App\Models\Menu\MenuItem;

class MenuItemOrderSuffix extends MenuItemSuffix
{
    public function get(MenuItem $menuItem): string
    {
        return '<span class="pull-right-container">
                    <span class="label label-primary pull-right">5</span>
                </span>';
    }
}
