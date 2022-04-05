<?php

namespace Vanguard\Presenters\Traits;

use Exception;

trait Presentable
{
    /**
     * @var \Vanguard\Presenters\Presenter
     */
    protected $presenterInstance;

    /**
     * @return mixed
     */
    public function present()
    {
        if (is_object($this->presenterInstance)) {
            return $this->presenterInstance;
        }
        if (property_exists($this, 'presenter') && class_exists($this->presenter)) {
            return $this->presenterInstance = new $this->presenter($this);
        }

        throw new Exception('Property $presenter was not set correctly in ' . static::class);
    }
}
