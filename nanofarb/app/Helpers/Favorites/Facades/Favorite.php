<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 31.01.19
 * Time: 21:29.
 */

namespace App\Helpers\Favorites\Facades;

class Favorite extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Helpers\Favorites\Favorite::class;
    }
}
