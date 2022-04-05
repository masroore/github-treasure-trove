<?php

use App\Cart;
use App\Commission;
use App\CommissionSetting;
use App\Language;
use App\ProductValues;
use App\Shipping;
use App\ShippingWeight;
use App\UserReview;
use App\Wishlist;

if (!function_exists('shippingprice')) {
    function shippingprice($cart)
    {
        $shipping = 0;

        if (isset($cart->simple_product)) {
            if ('0' == $cart->simple_product->free_shipping) {
                $free_shipping = Shipping::where('default_status', '=', '1')->first();

                if (isset($free_shipping)) {
                    if ('Shipping Price' == $free_shipping->name) {
                        $weight = ShippingWeight::first();
                        $pro_weight = $cart->simple_product->weight;
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
        }

        return $shipping;
    }
}

if (!function_exists('getcarttotal')) {
    function getcarttotal()
    {
        $total = 0;

        foreach (auth()->user()->cart as $val) {
            if ($val->product && $val->variant) {
                if (null != $val->product->tax_r && 0 == $val->product->tax) {
                    if (0 != $val->ori_offer_price) {
                        //get per product tax amount
                        $p = 100;
                        $taxrate_db = $val->product->tax_r;
                        $vp = $p + $taxrate_db;
                        $taxAmnt = $val->product->offer_price / $vp * $taxrate_db;
                        $taxAmnt = sprintf('%.2f', $taxAmnt);
                        $price = ($val->ori_offer_price - $taxAmnt) * $val->qty;
                    } else {
                        $p = 100;
                        $taxrate_db = $val->product->tax_r;
                        $vp = $p + $taxrate_db;
                        $taxAmnt = $val->product->price / $vp * $taxrate_db;

                        $taxAmnt = sprintf('%.2f', $taxAmnt);

                        $price = ($val->ori_price - $taxAmnt) * $val->qty;
                    }
                } else {
                    if (0 != $val->semi_total) {
                        $price = $val->semi_total;
                    } else {
                        $price = $val->price_total;
                    }
                }
            }

            if ($val->simple_product) {
                if (0 != $val->semi_total) {
                    $price = $val->semi_total - $val->tax_amount;
                } else {
                    $price = $val->price_total - $val->tax_amount;
                }
            }

            $total = $total + $price;
        }

        return $total;
    }
}

if (!function_exists('variantname')) {
    function variantname($orivar)
    {
        $i = 0;

        $varcount = count($orivar->main_attr_value);

        $varname = '';

        foreach ($orivar->main_attr_value as $key => $orivars) {
            ++$i;
            $getvarvalue = ProductValues::where('id', $orivars)->first();

            if (isset($getvarvalue)) {
                if ($i < $varcount) {
                    if (0 != strcasecmp($getvarvalue->unit_value, $getvarvalue->values) && null != $getvarvalue->unit_value) {
                        if ('Color' == $getvarvalue->proattr->attr_name || 'Colour' == $getvarvalue->proattr->attr_name || 'color' == $getvarvalue->proattr->attr_name || 'colour' == $getvarvalue->proattr->attr_name) {
                            $varname = $getvarvalue->values . ',';
                        } else {
                            $varname .= $getvarvalue->values . $getvarvalue->unit_value . ',';
                        }
                    } else {
                        $varname .= $getvarvalue->values . ',';
                    }
                } else {
                    if (0 != strcasecmp($getvarvalue->unit_value, $getvarvalue->values) && null != $getvarvalue->unit_value) {
                        if ('Color' == $getvarvalue->proattr->attr_name || 'Colour' == $getvarvalue->proattr->attr_name || 'color' == $getvarvalue->proattr->attr_name || 'colour' == $getvarvalue->proattr->attr_name) {
                            $varname .= $getvarvalue->values;
                        } else {
                            $varname .= $getvarvalue->values . $getvarvalue->unit_value;
                        }
                    } else {
                        $varname .= $getvarvalue->values;
                    }
                }
            }
        }

        return $varname;
    }
}

if (!function_exists('inwishlist')) {
    function inwishlist($id)
    {
        if (auth()->check()) {
            $check = Wishlist::where('user_id', auth()->id())->where('simple_pro_id', $id)->first();

            if (isset($check)) {
                return true;
            }

            return false;
        }

        return false;
    }
}

if (!function_exists('chekcincart')) {
    function chekcincart($id)
    {
        if (auth()->check()) {
            $check = Cart::where('user_id', auth()->id())->where('simple_pro_id', $id)->first();

            if (isset($check)) {
                return true;
            }

            return false;
        }

        return false;
    }
}

if (!function_exists('excl_tax_calculator')) {
    function excl_tax_calculator($price, $taxrate)
    {
        $tax = $price * ($taxrate / 100);

        return sprintf('%.2f', $tax);
    }
}

if (!function_exists('get_default_shipping')) {
    function get_default_shipping()
    {
        return Shipping::where('default_status', '1')->first();
    }
}

if (!function_exists('commission_calculator')) {
    function commission_calculator($price, $tax, $category_id)
    {
        $commission_setting = CommissionSetting::first();

        if ('flat' == $commission_setting->type) {
            if ('f' == $commission_setting->p_type) {
                $cit = $commission_setting->rate * $tax / 100;

                return sprintf('%.2f', $commission_setting->rate + $cit);
            }

            $taxrate = $commission_setting->rate;
            $tax1 = $price * ($taxrate / 100);

            return sprintf('%.2f', $tax1);
        }

        $comm = Commission::where('category_id', $category_id)->first();

        if (isset($comm)) {
            if ('f' == $comm->type) {
                $cit = $comm->rate * $tax / 100;

                return sprintf('%.2f', $comm->rate + $cit);
            }

            $taxrate = $comm->rate;
            $price1 = $price;

            return sprintf('%.2f', $price1 * ($taxrate / 100));
        }
    }
}

if (!function_exists('simple_product_rating')) {
    function simple_product_rating($id)
    {
        $review_t = 0;
        $price_t = 0;
        $value_t = 0;
        $sub_total = 0;
        $sub_total = 0;
        $ratings_var = 0;

        $reviews = UserReview::where('simple_pro_id', $id)
            ->where('status', '1')
            ->get();

        if (count($reviews)) {
            $count = count($reviews);

            foreach ($reviews as $review) {
                $review_t = $review->price * 5;
                $price_t = $review->price * 5;
                $value_t = $review->value * 5;
                $sub_total = $sub_total + $review_t + $price_t + $value_t;
            }

            $count = ($count * 3) * 5;
            $rat = $sub_total / $count;
            $ratings_var = ($rat * 100) / 5;
        }

        return $ratings_var;
    }
}

if (!function_exists('get_product_rating')) {
    function get_product_rating($id)
    {
        $review_t = 0;
        $price_t = 0;
        $value_t = 0;
        $sub_total = 0;
        $ratings_var = 0;
        $reviews = UserReview::where('pro_id', $id)->where('status', '1')->get();

        if (count($reviews)) {
            foreach ($reviews as $review) {
                $review_t = $review->price * 5;
                $price_t = $review->price * 5;
                $value_t = $review->value * 5;
                $sub_total = $sub_total + $review_t + $price_t + $value_t;
            }

            $count = (count($reviews) * 3) * 5;
            $rat = $sub_total / $count;
            $ratings_var = ($rat * 100) / 5;
        }

        return $ratings_var;
    }
}

if (!function_exists('get_release')) {
    function get_release()
    {
        $version = @file_get_contents(storage_path() . '/app/bugfixer/version.json');
        $version = json_decode($version, true);
        $current_subversion = $version['subversion'];

        return '(release ' . $current_subversion . ')';
    }
}

if (!function_exists('selected_lang')) {
    function selected_lang()
    {
        return Language::firstWhere('lang_code', '=', session()->get('changed_language') ?? config('translatable.fallback_locale'));
    }
}

if (!function_exists('price_format')) {
    function price_format($price)
    {
        if ('comma' == env('PRICE_DISPLAY_FORMAT')) {
            // French notation
            return sprintf('%s', number_format($price, 2, ',', ' '));
        }
        // English notation without thousands separator
        return number_format($price, 2, '.', '');
    }
}

if (!function_exists('pre_order_disable')) {
    function pre_order_disable()
    {
        if (auth()->check()) {
            $cart_table = Cart::where('user_id', auth()->id())
                ->whereHas('simple_product', function ($query) {
                    return $query->where('status', '1')->where('pre_order', '=', '1');
                })->get();

            if (count($cart_table)) {
                return true;
            }

            return false;
        }

        return false;
    }
}

if (!function_exists('support_check')) {
    function support_check()
    {
        $personalToken = 'inNy83FTjV2CTPqvNdPGRr2mAJ0raPC4';

        $code = file_exists(storage_path() . '/app/keys/license.json') && null != file_get_contents(storage_path() . '/app/keys/license.json') ? file_get_contents(storage_path() . '/app/keys/license.json') : '';

        $code = json_decode($code);

        if (null == $code || '' == $code->code) {
            return session()->flash('support_ping', __('Purchase code not found please contact support !'));
        }

        if (!preg_match('/^(\\w{8})-((\\w{4})-){3}(\\w{12})$/', $code->code)) {
            //throw new Exception("Invalid code");
            $message = __('Invalid Code');

            return session()->flash('support_ping', $message);
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            \CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code->code}",
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_TIMEOUT => 20,

            \CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$personalToken}",
            ],
        ]);

        // Send the request with warnings supressed
        $response = curl_exec($ch);

        // Handle connection errors (such as an API outage)
        if (curl_errno($ch) > 0) {
            //throw new Exception("Error connecting to API: " . curl_error($ch));
            $message = __('Error connecting to API ! ');

            return session()->flash('support_ping', $message);
        }
        // If we reach this point in the code, we have a proper response!
        // Let's get the response code to check if the purchase code was found
        $responseCode = curl_getinfo($ch, \CURLINFO_HTTP_CODE);

        // HTTP 404 indicates that the purchase code doesn't exist
        if (404 === $responseCode) {
            //throw new Exception("The purchase code was invalid");
            $message = __('Purchase Code is invalid !');

            return session()->flash('support_ping', $message);
        }

        // Anything other than HTTP 200 indicates a request or API error
        // In this case, you should again ask the user to try again later
        if (200 !== $responseCode) {
            //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
            $message = __('Failed to validate code !');

            return session()->flash('support_ping', $message);
        }

        // Parse the response into an object with warnings supressed
        $body = json_decode($response);

        // Check for errors while decoding the response (PHP 5.3+)
        if (false === $body && \JSON_ERROR_NONE !== json_last_error()) {
            //new Exception("Error parsing response");
            $message = __("Can't Verify Now !");

            return session()->flash('support_ping', $message);
        }

        if (null != $body->supported_until) {
            if (date('Y-m-d') == date('Y-m-d', strtotime($body->supported_until))) {
                return session()->flash('support_ping', __('Your envato support is expiring for this item today ! To renew it') . "<a class='alert-link' target='__blank' href='https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support'>" . __('Click here') . '</a>');
            }
            if (date('Y-m-d') > date('Y-m-d', strtotime($body->supported_until))) {
                return session()->flash('support_ping', __('Your envato support is expired for this item To renew it') . "<a class='alert-link' target='__blank' href='https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support'>" . __('Click here') . '</a>');
            }
        } else {
            return session()->flash('support_ping', __('This item does not have envato/author support !'));
        }
    }
}
