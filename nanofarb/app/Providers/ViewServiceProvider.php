<?php

namespace App\Providers;

use App\Http\View\FrontComposers\MenusComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            View::composer([
                'front.pages.home',
                'front.layouts.inc.footer',
                'front.layouts.inc.header',
            ], \App\Http\View\FrontComposers\MenusComposer::class);

            //View::composer('front.products.inc.modal-cart', \App\Http\View\FrontComposers\ShoppingCartComposer::class);
            //
            //View::composer('front.products.inc.modal-favorites', \App\Http\View\FrontComposers\FavoriteProductsComposer::class);
        }
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MenusComposer::class);
    }
}
