<?php
/*
 * File name: CurrencyCast.php
 * Last modified: 2021.08.10 at 18:03:34
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Casts;

use App\Models\Currency as CurrencyModel;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

/**
 * Class CurrencyCast.
 */
class CurrencyCast implements CastsAttributes
{
    /**
     * {@inheritDoc}
     */
    public function get($model, string $key, $value, array $attributes): CurrencyModel
    {
        if (!empty($value)) {
            $decodedValue = json_decode($value, true);
            $currency = new CurrencyModel($decodedValue);
            $currency->fillable[] = 'id';
            $currency->id = $decodedValue['id'];

            return $currency;
        }

        return new CurrencyModel();
    }

    /**
     * {@inheritDoc}
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        if (!$value instanceof CurrencyModel) {
            throw new InvalidArgumentException('The given value is not an Currency instance.');
        }

        return ['currency' => json_encode([
            'id' => $value['id'],
            'name' => $value['name'],
            'symbol' => $value['symbol'],
            'code' => $value['code'],
            'decimal_digits' => $value['decimal_digits'],
            'rounding' => $value['rounding'],
        ])];
    }
}
