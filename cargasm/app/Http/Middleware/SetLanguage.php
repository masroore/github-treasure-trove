<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLanguage
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
        // Don't redirect the console
        if (app()->runningInConsole() || !$request->isMethod('get')) {
            return $next($request);
        }

        // Устанавливаем язык контента/интерфейса для фронта (client).
        if (!empty($request->header('language'))) {
            App::setLocale($request->header('language'));
        }

        // Устанавливаем языки для работы в админке.
        //$allowedLanguages = ['ru', 'en', 'de', 'fr'];
        $allowedLanguages = get_languages_keys();
        config()->set('app.languages', $allowedLanguages);

        if ($request->has('_lang')) {
            if (in_array($request->_lang, $allowedLanguages)) {
                config()->set('app.languages', $request->_lang);
            } elseif ($request->_lang === 'all' || $request->_lang === '') {
                config()->set('app.languages', '');
            }
        }

        return $next($request);
    }
}
