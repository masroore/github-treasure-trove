<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SalePromoCode implements Rule
{
    protected $message = '';

    protected $usedLimit;

    /**
     * Create a new rule instance.
     */
    public function __construct($usedLimit = 0)
    {
        $this->usedLimit = $usedLimit;
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
        $this->message = 'The validation error message.';

        if (!($promoCode = \App\Models\Shop\SalePromoCode::where('code', $value)->first())) {
            $this->message = 'Значение промокода введено не верно!';

            return false;
        }
        if (!\App\Models\Shop\SalePromoCode::where('code', $value)->isAvailable()->first()) {
            $this->message = 'Срок действия промокода истек!';

            return false;
        }
        if ($this->usedLimit > 0) {
            if (!\App\Models\Shop\SalePromoCode::where('code', $value)->where(function ($c): void {
                $c->whereColumn('used_limit', '>', 'used_count')->orWhere('used_limit', 0);
            })->first()) {
                $this->message = 'Промокод уже использован!';

                return false;
            }
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
        return $this->message;
    }
}
