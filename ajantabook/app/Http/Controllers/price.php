<?php

use App\Allcountry;
use App\AutoDetectGeo;
use App\CurrencyNew;

$conversion_rate = 1;

$myip = request()->getClientIp();

$geolocation = geoip()->getLocation($myip);

$setting = AutoDetectGeo::first();

$defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {
    return $query->where('default_currency', '1');
})->first();

if ('1' == $setting->enabel_multicurrency) {
    if ('1' == $setting->auto_detect && '0' == $setting->currency_by_country) {

        //if auto detect is ON and currency by country is OFF

        if (session()->has('currency')) {
            if (session()->get('current_cur') == $defaultCurrency->code) {

                // if default currency in request

                Session::put('currency', [
                    'id' => $defaultCurrency->code,
                    'mainid' => $defaultCurrency->id,
                    'value' => $defaultCurrency->currencyextract->currency_symbol,
                    'position' => $defaultCurrency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
            } else {
                $currency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract')->firstWhere('code', '=', session()->get('current_cur'));

                // if currency found

                if (isset($currency)) {
                    $from = $defaultCurrency->code;
                    $to = session()->get('current_cur');

                    $rate = currency(1.00, $from, $to, $format = false);

                    Session::put('currency', [
                        'id' => $currency->code,
                        'mainid' => $currency->id,
                        'value' => $currency->currencyextract->currency_symbol,
                        'position' => $currency->currencyextract->position,
                    ]);

                    $conversion_rate = (float) sprintf('%.2f', $rate + $currency->currencyextract->add_amount);
                } else {

                    // if currency not found put default currency again

                    Session::put('currency', [
                        'id' => $defaultCurrency->code,
                        'mainid' => $defaultCurrency->id,
                        'value' => $defaultCurrency->currencyextract->currency_symbol,
                        'position' => $defaultCurrency->currencyextract->position,
                    ]);

                    $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
                }
            }
        } else {
            $currency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract')->firstWhere('code', '=', $geolocation->currency);

            // if currency found

            if (isset($currency)) {
                $from = $defaultCurrency->code;
                $to = session()->get('current_cur');

                $rate = currency(1.00, $from, $to, $format = false);

                Session::put('currency', [
                    'id' => $currency->code,
                    'mainid' => $currency->id,
                    'value' => $currency->currencyextract->currency_symbol,
                    'position' => $currency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', $rate + $currency->currencyextract->add_amount);
            } else {

                    // if currency not found put default currency again

                Session::put('currency', [
                    'id' => $defaultCurrency->code,
                    'mainid' => $defaultCurrency->id,
                    'value' => $defaultCurrency->currencyextract->currency_symbol,
                    'position' => $defaultCurrency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
            }
        }
    } elseif ('1' == $setting->auto_detect && '1' == $setting->currency_by_country) {
        if (session()->has('currency')) {
            if (session()->get('current_cur') == $defaultCurrency->code) {
                Session::put('currency', [
                    'id' => $defaultCurrency->code,
                    'mainid' => $defaultCurrency->id,
                    'value' => $defaultCurrency->currencyextract->currency_symbol,
                    'position' => $defaultCurrency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
            } else {
                $getLocation = Allcountry::where('nicename', '=', $geolocation->country)->orWhere('name', $geolocation->country)->first();

                $currency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract')->firstWhere('code', '=', session()->get('current_cur'));

                if (isset($getLocation, $currency, $currency->currencyextract->currencyLocationSettings)) {
                    if (in_array($getLocation->id, [$currency->currencyextract->currencyLocationSettings->country_id])) {
                        $from = $defaultCurrency->code;
                        $to = session()->get('current_cur');

                        $rate = currency(1.00, $from, $to, $format = false);

                        Session::put('currency', [
                            'id' => $currency->code,
                            'mainid' => $currency->id,
                            'value' => $currency->currencyextract->currency_symbol,
                            'position' => $currency->currencyextract->position,
                        ]);

                        $conversion_rate = (float) sprintf('%.2f', $rate + $currency->currencyextract->add_amount);
                    } else {
                        Session::put('currency', [
                            'id' => $defaultCurrency->code,
                            'mainid' => $defaultCurrency->id,
                            'value' => $defaultCurrency->currencyextract->currency_symbol,
                            'position' => $defaultCurrency->currencyextract->position,
                        ]);

                        $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
                    }
                } else {
                    Session::put('currency', [
                        'id' => $defaultCurrency->code,
                        'mainid' => $defaultCurrency->id,
                        'value' => $defaultCurrency->currencyextract->currency_symbol,
                        'position' => $defaultCurrency->currencyextract->position,
                    ]);

                    $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
                }
            }
        } else {
            $currency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract')->firstWhere('code', '=', $geolocation->currency);

            if (isset($currency, $currency->currencyextract->currencyLocationSettings)) {
                $getLocation = Allcountry::where('nicename', '=', $geolocation->country)->orWhere('name', $geolocation->country)->first();

                if (in_array($getLocation->id, [$currency->currencyextract->currencyLocationSettings->country_id])) {
                    $from = $defaultCurrency->code;
                    $to = session()->get('current_cur');

                    $rate = currency(1.00, $from, $to, $format = false);

                    Session::put('currency', [
                        'id' => $currency->code,
                        'mainid' => $currency->id,
                        'value' => $currency->currencyextract->currency_symbol,
                        'position' => $currency->currencyextract->position,
                    ]);

                    $conversion_rate = (float) sprintf('%.2f', $rate + $currency->currencyextract->add_amount);
                } else {
                    Session::put('currency', [
                        'id' => $defaultCurrency->code,
                        'mainid' => $defaultCurrency->id,
                        'value' => $defaultCurrency->currencyextract->currency_symbol,
                        'position' => $defaultCurrency->currencyextract->position,
                    ]);

                    $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
                }
            } else {
                Session::put('currency', [
                    'id' => $defaultCurrency->code,
                    'mainid' => $defaultCurrency->id,
                    'value' => $defaultCurrency->currencyextract->currency_symbol,
                    'position' => $defaultCurrency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
            }
        }
    } else {

        // if both are disabled

        if (session()->has('currency')) {
            if (session()->get('current_cur') == $defaultCurrency->code) {
                Session::put('currency', [
                    'id' => $defaultCurrency->code,
                    'mainid' => $defaultCurrency->id,
                    'value' => $defaultCurrency->currencyextract->currency_symbol,
                    'position' => $defaultCurrency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
            } else {
                $currency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract')->firstWhere('code', '=', session()->get('current_cur'));
            }

            // if currency found

            if (isset($currency)) {
                $from = $defaultCurrency->code;
                $to = session()->get('current_cur');

                $rate = currency(1.00, $from, $to, $format = false);

                Session::put('currency', [
                    'id' => $currency->code,
                    'mainid' => $currency->id,
                    'value' => $currency->currencyextract->currency_symbol,
                    'position' => $currency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', $rate + $currency->currencyextract->add_amount);
            } else {

            // if currency not found put default currency again

                Session::put('currency', [
                    'id' => $defaultCurrency->code,
                    'mainid' => $defaultCurrency->id,
                    'value' => $defaultCurrency->currencyextract->currency_symbol,
                    'position' => $defaultCurrency->currencyextract->position,
                ]);

                $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
            }
        } else {
            Session::put('currency', [
                'id' => $defaultCurrency->code,
                'mainid' => $defaultCurrency->id,
                'value' => $defaultCurrency->currencyextract->currency_symbol,
                'position' => $defaultCurrency->currencyextract->position,
            ]);

            $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
        }
    }
} else {

    // if multicurrency system is disabled

    Session::put('currency', [
        'id' => $defaultCurrency->code,
        'mainid' => $defaultCurrency->id,
        'value' => $defaultCurrency->currencyextract->currency_symbol,
        'position' => $defaultCurrency->currencyextract->position,
    ]);

    $conversion_rate = (float) sprintf('%.2f', 1 + $defaultCurrency->currencyextract->add_amount);
}

// dd(session()->get('currency'));
