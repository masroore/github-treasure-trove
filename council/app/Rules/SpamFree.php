<?php

namespace App\Rules;

use App\Inspections\Spam;
use Exception;

class SpamFree
{
    /**
     * Determine if the given attribute passes our spam validation.
     *
     * @param  string $attribute
     * @param  string $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return !resolve(Spam::class)->detect($value);
        } catch (Exception $e) {
            return false;
        }
    }
}
