<?php

namespace App\Http\Middleware;

use App;
use Closure;

class XSS
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
        if (\Auth::check()) {
            App::setLocale(\Auth::user()->lang);
        }
        $input = $request->all();
        array_walk_recursive(
            $input,
            function (&$input): void {
                $input = strip_tags($input);
            }
        );
        $request->merge($input);

        return $next($request);
    }
}
