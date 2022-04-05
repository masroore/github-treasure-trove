<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /**
     * @var int
     */
    protected $minLength = 8;

    /**
     * @var bool
     */
    protected $needsNumber = true;

    /**
     * @var bool
     */
    protected $needsUppercaseLetter = true;

    /**
     * @var bool
     */
    protected $needsSpecialCharacter = true;

    /**
     * @return $this
     */
    public function minLength(int $minLength)
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @return $this
     */
    public function needsNumber(bool $requires = true)
    {
        $this->needsNumber = $requires;

        return $this;
    }

    /**
     * @return $this
     */
    public function needsUppercaseLetter(bool $requires = true)
    {
        $this->needsUppercaseLetter = $requires;

        return $this;
    }

    /**
     * @return $this
     */
    public function needsSpecialCharacter(bool $requires = true)
    {
        $this->needsSpecialCharacter = $requires;

        return $this;
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
        if (mb_strlen($value) < $this->minLength) {
            return false;
        }

        // Do we need at least 1 number
        if ($this->needsNumber && !preg_match('/[0-9]{1,}/', $value)) {
            return false;
        }

        // Do we need at least 1 uppercase letter
        if ($this->needsUppercaseLetter && !preg_match('/[A-Z]{1,}/', $value)) {
            return false;
        }

        if ($this->needsSpecialCharacter && !preg_match('/[!@Â£\$%\^&\*\(\)_\+#\-\/\\\[\]\{\}\.,=~:;]{1,}/', $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The password entered in the :attribute field isn\'t strong enough';
    }
}
