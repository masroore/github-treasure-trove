<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RuleOdnoklassniki implements Rule
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
        return preg_match('/(?:https:\/\/)?(?:http:\/\/)?(?:www\.)?(?:ok|odnoklassniki)\.ru\/(?:\w*#!\/)?([\w-]*)?/', $value);
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
