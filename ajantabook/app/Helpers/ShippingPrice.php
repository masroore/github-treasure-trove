<?php

class ShippingPrice
{
    public static function calculateShipping($cart)
    {
        $shipping = 0;

        if ($cart->variant && $cart->product && 0 == $cart->product->free_shipping) {
            $free_shipping = App\Shipping::where('id', $cart->product->shipping_id)->first();

            if (!empty($free_shipping)) {
                if ('Shipping Price' == $free_shipping->name) {
                    $weight = App\ShippingWeight::first();
                    $pro_weight = $cart->variant->weight;
                    if ($weight->weight_to_0 >= $pro_weight) {
                        if ('po' == $weight->per_oq_0) {
                            $shipping = $shipping + $weight->weight_price_0;
                        } else {
                            $shipping = $shipping + $weight->weight_price_0 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_1 >= $pro_weight) {
                        if ('po' == $weight->per_oq_1) {
                            $shipping = $shipping + $weight->weight_price_1;
                        } else {
                            $shipping = $shipping + $weight->weight_price_1 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_2 >= $pro_weight) {
                        if ('po' == $weight->per_oq_2) {
                            $shipping = $shipping + $weight->weight_price_2;
                        } else {
                            $shipping = $shipping + $weight->weight_price_2 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_3 >= $pro_weight) {
                        if ('po' == $weight->per_oq_3) {
                            $shipping = $shipping + $weight->weight_price_3;
                        } else {
                            $shipping = $shipping + $weight->weight_price_3 * $cart->qty;
                        }
                    } else {
                        if ('po' == $weight->per_oq_4) {
                            $shipping = $shipping + $weight->weight_price_4;
                        } else {
                            $shipping = $shipping + $weight->weight_price_4 * $cart->qty;
                        }
                    }
                } else {
                    $shipping = $free_shipping->price;
                }
            }
        }

        return $shipping;
    }
}
