<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RuleFacebook implements Rule
{
    /**
     * Create a new rule instance.
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
//        return (bool) preg_match('/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/',$value);
        return (bool) preg_match('/http(?:s):\/\/(?:www\.)facebook\.com\/.+/i', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.url');
    }
}
