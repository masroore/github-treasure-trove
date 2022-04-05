<?php

namespace App\Http\Middleware;

use App\Helpers\Encryptor;
use Closure;

class CryptId
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('post')) {
            foreach ($request->request as $key => $value) {
                if ($key == 'id') {
                    $request->request->set($key, Encryptor::decrypt($value));
                }
            }

            return $next($request);
        }
        if ($request->isMethod('get')) {
            foreach ($request->route()->parameters as $key => $value) {
                if ($key == 'id') {
                    $request->route()->setParameter($key, Encryptor::decrypt($value));
                }
            }

            return $next($request);
        }
    }
}
