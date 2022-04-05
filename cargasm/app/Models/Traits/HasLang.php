<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\App;

trait HasLang
{
    /**
     * @param $query
     * @param null $locale
     *
     * @return mixed
     */
    public function scopeByLang($query, $locale = null)
    {
        $locale = $locale ?: App::getLocale();

//        return $query->whereLang($locale)
//            ->orWhereNull('lang');
        return $query;
    }

    /**
     * @param $query
     * @param null $locales
     *
     * @return mixed
     */
    public function scopeByLangs($query, $locales = null)
    {
        $locales = $locales ?: config('app.languages');

        return $query;
//        if ($locales) {
//            return $query->whereIn('lang', is_array($locales) ? $locales : [$locales])
//                ->orWhereNull('lang');
//
//        }
    }
}
