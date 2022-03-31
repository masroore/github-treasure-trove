<?php

namespace Agmedia\Category\Facades;

use Illuminate\Support\Facades\Facade;

class Category extends Facade
{
    public static function getLists()
    {
        $category = new \Agmedia\Category\Category();

        return $category->getList();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'category';
    }
}
