<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->session()->get('user_locale');

        if (!$locale) {
            $locale = config('app.locale');
        }

        //set user wise locale

        //dd($locale);
        App::setLocale($locale);

        return $next($request);
    }
}
