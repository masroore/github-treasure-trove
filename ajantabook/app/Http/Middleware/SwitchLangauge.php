<?php

namespace App\Http\Middleware;

use App;
use App\Language;
use Closure;
use Exception;
use Session;

class SwitchLangauge
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('changed_language')) {
            try {
                $defLang = Language::where('def', '=', 1)->first();

                if (isset($defLang)) {
                    Session::put('changed_language', str_replace('_', '-', $defLang->lang_code));
                } else {
                    Session::put('changed_language', 'en');
                }
            } catch (Exception $e) {
                Session::put('changed_language', 'en');
            }
        }

        App::setLocale(Session::get('changed_language'));

        return $next($request);
    }
}
