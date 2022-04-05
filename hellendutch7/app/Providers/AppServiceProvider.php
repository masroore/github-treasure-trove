<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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

        view()->composer(['dashboard.components.dash_left',
            'products.form',
            'components.layout.dash_left',
        ], function ($view): void {
            $view->with('categories', Category::where('active', 1)->orderBy('category', 'asc')->get());
        });

        view()->composer(['categories.index',
        ], function ($view): void {
            $view->with('categories', Category::orderBy('category', 'asc')->get());
        });
    }
}
