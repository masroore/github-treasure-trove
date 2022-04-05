<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 30.01.19
 * Time: 11:33.
 */

namespace App\Helpers\Currency\Facades;

use Illuminate\Support\Facades\Facade;

class Currency extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Helpers\Currency\Currency::class;
    }
}
