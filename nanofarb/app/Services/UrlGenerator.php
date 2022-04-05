<?php

namespace App\Services;

use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Str;

class UrlGenerator extends BaseUrlGenerator
{
    /**
     * Format the given URL segments into a single URL.
     *
     * @param  string  $root
     * @param  string  $path
     * @param  null|\Illuminate\Routing\Route  $route
     *
     * @return string
     */
    public function format($root, $path, $route = null)
    {
        $patterns = ['*laravel-filemanager*', '*lfm-photos*', '*lfm-files*'];
        $isFiles = preg_match('/\\.(\w){1,6}$/', $path); // ex.: "http://site.test/img/42122c.jpg/" => "http://site.test/img/42122c.jpg"

        if (request()->is($patterns) || Str::is($patterns, $path) || $isFiles) {
            return parent::format($root, $path, $route);
        }

        return parent::format($root, $path, $route) . (str_contains($path, '#') ? '' : '/');
    }
}
