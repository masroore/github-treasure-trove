<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 05.02.19
 * Time: 16:43.
 */

namespace App\Managers;

use App\Models\Shop\Sale;

class SaleManager
{
    public function saveOptions(Sale $sale, array $attributes): void
    {
        if (isset($attributes['discount_type'])) {
            $sale->update([
                'discount_type' => $attributes['discount_type'],
                'discount' => $attributes['discount_type'] == Sale::DISCOUNT_TYPE_SUM ? $attributes['discount'] * 100 : $attributes['discount'],
            ]);
        }

        if (isset($attributes['terms']) && is_array($attributes['terms'])) {
            $sale->terms()->sync(array_values_recursive($attributes['terms']));
        }

        if (isset($attributes['data']['min_sum'])) {
            $sale->setAttribute('data->min_sum', $attributes['data']['min_sum'] * 100);
        }
        if (isset($attributes['data']['product_present'])) {
            $sale->setAttribute('data->product_present', $attributes['data']['product_present']);
        }

        $sale->save();

        if (isset($attributes['products']) && is_array($attributes['products'])) {
            $sale->products()->sync($attributes['products']);
        } else {
            $sale->products()->detach(); //https://i.imgur.com/jVFpUjH.png
        }
    }
}
