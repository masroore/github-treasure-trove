<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 24.01.19
 * Time: 1:11.
 */

namespace App\Helpers\FacetFilter;

use Illuminate\Support\Facades\Facade;

class FacetFilter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FacetFilterBuilder::class;
    }
}
