<?php

namespace Modules\AdminCoupon\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminCouponServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('AdminCoupon', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/admincoupon');

        $sourcePath = module_path('AdminCoupon', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admincoupon';
        }, Config::get('view.paths')), [$sourcePath]), 'admincoupon');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
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
     */
    public function registerFactories(): void
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
     */
    protected function registerConfig(): void
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
