<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 30.01.19
 * Time: 10:55.
 */

namespace App\Helpers\Currency;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Currency
{
    protected $config;

    protected $symbol;

    /**
     * Currency constructor.
     */
    public function __construct($app = null)
    {
        if (!$app) {
            $app = app();   //Fallback when $app is not given
        }
        $this->app = $app;

        $this->config = $this->app['config'];
    }

    public function getNBURates()
    {
        $cacheKey = __METHOD__ . '1';
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $rates = file_get_contents('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json');
            $res = json_decode($rates, true);
            Cache::put($cacheKey, $res, 30);

            return $res;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function convert($fromVal, $fromCurrency, $toCurrency, bool $doFormat = true)
    {
        try {
            $array = $this->getNBURates();

            $rate = array_search_associative($toCurrency, $array, 'cc', 'rate');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return '';
        }

        $val = $fromVal / 100 / $rate;

        if ($doFormat) {
            return $this->doFormat($val, $toCurrency);
        }

        return $val;
    }

    public function convertUsd($fromCurrency)
    {
        $array = $this->getNBURates();
        $rate = array_search_associative($fromCurrency, $array, 'cc', 'rate');

        return $rate;
    }

    public function convertSelf($fromVal, $fromCurrency, $toCurrency, bool $doFormat = true)
    {
        try {
            $array = $this->getNBURates();

            $rate = array_search_associative($toCurrency, $array, 'cc', 'rate');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return '';
        }

        $val = $fromVal / $rate;

        if ($doFormat) {
            return $this->doFormat($val, $toCurrency);
        }

        return $val;
    }

    public function getNBURatesStr()
    {
        $toCurrencies = ['USD', 'EUR'];
        $res = [];
        $rates = $this->getNBURates();
        foreach ($toCurrencies as $toCurrency) {
            if ($rate = array_search_associative($toCurrency, $rates, 'cc', 'rate')) {
                $res[] = $toCurrency . ': ' . round($rate, 2);
            }
        }

        return implode(', ', $res);
    }

    public function getConvertsStr($priceVal, $fromCurrency, bool $doFormat = true)
    {
        $toCurrencies = ['USD', 'EUR'];
        $res = [];
        foreach ($toCurrencies as $toCurrency) {
            if ($val = $this->convert($priceVal, $fromCurrency, $toCurrency, $doFormat)) {
                $res[] = $val;
            }
        }

        return implode(', ', $res);
    }

    /**
     * @param $value
     * @param null $code
     * @param null $symbol
     *
     * @return string
     */
    public function format($value, $code = null, $symbol = null)
    {
        $code = $this->prepareCode($code);
        $value = $value / 100;

        return $this->doFormat($value, $code, $symbol);
    }

    public function doFormat($value, $code = null, $symbol = null)
    {
        $precision = $this->config->get("currency.currencies.$code.precision", 0);
        $decimalSeparator = $this->config->get("currency.currencies.$code.decimalSeparator", '');
        $thousandSeparator = $this->config->get("currency.currencies.$code.thousandSeparator", '');

        $symbol ??= $this->config->get("currency.currencies.$code.symbol", '');

        $result = number_format($value, $precision, $decimalSeparator, $thousandSeparator);

        if ($symbol !== null) {
            return $this->config->get("currency.currencies.$code.symbolPlacement") === 'after'
                ? $result . $symbol
                : $symbol . $result;
        }

        return $result;
    }

    /**
     * @param null $code
     *
     * @return null|string
     */
    protected function prepareCode($code = null)
    {
        if (!$code) {
            $code = $this->config->get('currency.default', 'USD');
        }

        if (array_key_exists($code, $this->config->get('currency.currencies', []))) {
            return $code;
        }

        return 'USD';
    }

    public function getDefault(?string $key = null)
    {
        $defaultKey = $this->config->get('currency.default', 'USD');

        $default = $this->config->get("currency.currencies.$defaultKey", []);
        if ($key) {
            return $default[$key] ?? '';
        }

        return $default;
    }
}
