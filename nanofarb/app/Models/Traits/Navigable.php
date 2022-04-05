<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 04.02.19
 * Time: 11:13.
 */

namespace App\Models\Traits;

trait Navigable
{
    public function previous()
    {
        $sortField = $this->getKeyName();

        return static::where($sortField, '<', $this->getKey())->orderByDesc($sortField)
            ->first();
    }

    public function next()
    {
        $sortField = $this->getKeyName();

        return static::where($sortField, '>', $this->getKey())->orderBy($sortField)
            ->first();
    }
}
