<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        Response::macro('result', function ($data = [], $message = '', $status = 200, $validate = null) {
            $message = __($message);
            $errors = request()->errors();
            $response = compact('data', 'message', 'validate', 'errors');

            return Response::json($response, $status, []);
        });

        Response::macro('error', function ($message = '', $status = 200, $validate = null) {
            $message = __($message);
            $errors = request()->errors();
            $response = compact('message', 'validate', 'errors');

            return Response::json($response, $status, []);
        });

        Request::macro('addError', function ($text = '', $type = 'error'): void {
            if (!isset($this->errors)) {
                $this->errors = [];
            }
            $this->errors = array_merge($this->errors, [__($text) => $type]);
        });

        Request::macro('errors', function () {
            return $this->errors;
        });
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
    }
}
