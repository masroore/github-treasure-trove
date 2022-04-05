<?php

namespace Modules\ExternalShop\Import\Models;

abstract class Model
{
    protected $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
