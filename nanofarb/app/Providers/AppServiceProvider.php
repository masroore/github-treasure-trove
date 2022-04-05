<?php

namespace App\Providers;

use App\Helpers\Currency\Currency;
use App\Helpers\FacetFilter\FacetFilterBuilder;
use App\Helpers\Favorites\Facades\Favorite;
use App\Helpers\Menu\Menu;
use App\Helpers\ShoppingCart\Cart;
use App\Models\Shop\Attribute;
use App\Models\Shop\Value;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use UrlAliasLocalization;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Shop\Product::observe(\App\Observers\Shop\ProductObserver::class);
        \App\Models\Shop\Sale::observe(\App\Observers\Shop\SaleObserver::class);
        \App\Models\Shop\Order::observe(\App\Observers\Shop\OrderObserver::class);
        \App\Models\Taxonomy\Term::observe(\App\Observers\TermObserver::class);
        \App\Models\Page::observe(\App\Observers\PageObserver::class);
        \App\Models\News::observe(\App\Observers\NewsObserver::class);

        Validator::extend('password_current', function ($attribute, $value, $parameters, $validator) {
            return \Illuminate\Support\Facades\Hash::check($value, current($parameters));
        });

        Validator::extend('locale', function ($attribute, $value, $parameters, $validator) {
            return in_array($value, UrlAliasLocalization::getSupportedLanguagesKeys());
        });

        $tining = Value::where('attribute_id', Attribute::PURPOSE_TINTING_FACADE)->orWhere('attribute_id', Attribute::PURPOSE_TINTING_INTERIOR)->get();

        View::share('tining', $tining);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FacetFilterBuilder::class, function ($app) {
            return new FacetFilterBuilder();
        });

        $this->app->singleton(Menu::class, function ($app) {
            return new Menu($app);
        });

        $this->app->bind(Favorite::class);
        foreach (\App\Helpers\Favorites\Favorite::$storageDrivers as $name => $class) {
            $this->app->singleton($class);
        }

        $this->app->bind(Cart::class, function ($app) {
            return new Cart($app);
        });
        foreach ($this->app['config']->get('shopping-cart.storage_drivers') as $name => $class) {
            $this->app->singleton($class);
        }

        //$this->app->bound(Currency::class, function ($app) {
        //    return new Currency($app);
        //});

        //$this->app['config']->set('currency.currencies.USD.symbol', '$');
        if (!$this->app->request->is('admin*')) {
            $this->app['config']->set('currency.currencies.UAH.precision', '0');
        }
    }
}
