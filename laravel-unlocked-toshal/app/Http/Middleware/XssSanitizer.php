<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class XssSanitizer
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$input): void {
            $input = htmlentities($input, ENT_QUOTES, 'UTF-8', false);
        });

        $request->merge($input);

        return $next($request);
    }
}
