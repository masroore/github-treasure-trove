<?php

use App\Helpers\UrlSlugGenerator as UrlSlugGeneratorAlias;
use App\Models\Domain;
use App\Models\Language as LanguageAlias;
use Illuminate\Support\Str;

if (!function_exists('url_slug_get')) {
    function url_slug_get(Illuminate\Database\Eloquent\Model $model, $strSlug = null)
    {
        return app(UrlSlugGeneratorAlias::class)->slugGet($model, $strSlug);
    }
}

if (!function_exists('get_domain')) {
    function get_domain(?string $client = null)
    {
        $client = $client ?: request()->header('client');

        return \Illuminate\Support\Facades\Cache::remember(md5('get_domain' . $client), 60, function () use ($client) {
            return Domain::where('url', $client)->first() ?? Domain::first();
        });
    }
}

if (!function_exists('get_languages_keys')) {
    function get_languages_keys()
    {
        $client = request()->header('client');

        return \Illuminate\Support\Facades\Cache::remember(md5('get_languages_keys' . $client), 60, function () use ($client) {
            if ($domain = get_domain($client)) {
                return array_column($domain->languages->toArray(), 'lang');
            }

            return [];
        });
    }
}

if (!function_exists('get_languages')) {
    function get_languages()
    {
        $client = request()->header('client');

        return \Illuminate\Support\Facades\Cache::remember(md5('get_languages' . $client), 60, function () use ($client) {
            if ($domain = get_domain($client)) {
                return $domain->languages;
            }

            return new \Illuminate\Support\Collection();
        });
    }
}

if (!function_exists('name_from_lang')) {
    function name_from_lang($lang)
    {
        $language = LanguageAlias::where('lang', $lang)->first();

        if ($language) {
            return $language->name;
        }
    }
}

if (!function_exists('hide_vin')) {
    function hide_vin($string)
    {
        $start = mb_substr($string, 0, 3, 'UTF-8');
        $end = mb_substr($string, -3, 3, 'UTF-8');

        return $start . '***********' . $end;
    }
}

if (!function_exists('clean_text')) {
    function clean_text($text)
    {
        $text = strip_tags(preg_replace('/<figure\b[^>]*>(.*?)<\/figure>/i', '', $text));
        $text = str_replace('&nbsp;', '', $text);

        return Str::limit($text, 600, '');
    }
}

if (!function_exists('comparison_boolean_value')) {
    function comparison_boolean_value($value)
    {
        return ($value === 'true' || $value === '1' || $value === true || $value === 1) ? true : false;
    }
}

if (!function_exists('check_login_type')) {
    function check_login_type($value)
    {
        if (strpos($value, '@') !== false) {
            return true;
        }

        preg_match('/[a-z]/i', $value, $matches);
        if (empty($matches)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('get_image_language')) {
    function get_image_language($code)
    {
        foreach (config('languages') as $key => $data) {
            if ($data['code'] === $code) {
                if (file_exists(dirname(__FILE__, 2) . '/public/flags/' . basename($data['flag']))) {
                    return $data['flag'];
                }

                return '';
            }
        }
    }
}
