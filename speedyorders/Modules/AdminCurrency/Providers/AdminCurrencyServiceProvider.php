<?php

namespace Modules\AdminCurrency\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminCurrencyServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminCurrency', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/admincurrency');

        $sourcePath = module_path('AdminCurrency', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admincurrency';
        }, \Config::get('view.paths')), [$sourcePath]), 'admincurrency');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/admincurrency');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admincurrency');
        } else {
            $this->loadTranslationsFrom(module_path('AdminCurrency', 'Resources/lang'), 'admincurrency');
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
            app(Factory::class)->load(module_path('AdminCurrency', 'Database/factories'));
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
            module_path('AdminCurrency', 'Config/config.php') => config_path('admincurrency.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminCurrency', 'Config/config.php'),
            'admincurrency'
        );
    }
}
