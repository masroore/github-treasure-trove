<?php

namespace App\Providers;

use App\Topic;
use App\User;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('no_spaces', function ($attributes, $value, $parameters) {
            // checks that there are no spaces in the value
            return !preg_match('/\s/', $value);
        });
        Validator::extend('hash', function ($attributes, $value, $parameters) {
            // hashes a value
            return Hash::check($value, $parameters[0]);
        });
        Validator::extend('unique_slug_title', function ($attributes, $value, $parameters) {
            // checks if slug'ified version of the title is unique, compared to existing slugs
            return !Topic::where('slug', str_slug(mb_strimwidth($value, 0, 255), '-'))->first();
        });
        Validator::extend('user_exists', function ($attributes, $value, $parameters) {
            // gets the 1st @username in the value being checked and returns the user, if it exists
            $matches = [];
            preg_match_all('/^@\w+/', $value, $matches);

            return User::where('name', str_replace('@', '', $matches[0][0]))->first();
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (env('APP_ENV') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
