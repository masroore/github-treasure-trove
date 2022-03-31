<?php

namespace Modules\AdminCoupon\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminCouponServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('AdminCoupon', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/admincoupon');

        $sourcePath = module_path('AdminCoupon', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admincoupon';
        }, \Config::get('view.paths')), [$sourcePath]), 'admincoupon');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/admincoupon');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admincoupon');
        } else {
            $this->loadTranslationsFrom(module_path('AdminCoupon', 'Resources/lang'), 'admincoupon');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminCoupon', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('AdminCoupon', 'Config/config.php') => config_path('admincoupon.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminCoupon', 'Config/config.php'),
            'admincoupon'
        );
    }
}
