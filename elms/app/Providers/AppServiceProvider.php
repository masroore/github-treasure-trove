<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view): void {
            $view->with('whereami', Session::get('whereami'));
        });

        Gate::define('viewWebTinker', function ($user) {
            return in_array($user->email, ['elms@sksu.edu.ph']);
        });
    }
}
