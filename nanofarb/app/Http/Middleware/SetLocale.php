<?php

namespace App\Http\Middleware;

use Closure;
use UrlAliasLocalization;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('locale') && in_array($request->get('locale'), UrlAliasLocalization::getSupportedLanguagesKeys())) {
            app()->setLocale($request->get('locale'));
        }

        if (UrlAliasLocalization::getCurrentLocale() === 'ru') {
            config()->set('currency.currencies.UAH.symbol', ' грн.');
        } else {
            config()->set('currency.currencies.UAH.symbol', ' uah.');
        }

        return $next($request);
    }
}
