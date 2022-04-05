<?php

namespace Modules\CustomerLogin\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class CustomerLoginServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('CustomerLogin', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/customerlogin');

        $sourcePath = module_path('CustomerLogin', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/customerlogin';
        }, Config::get('view.paths')), [$sourcePath]), 'customerlogin');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/customerlogin');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'customerlogin');
        } else {
            $this->loadTranslationsFrom(module_path('CustomerLogin', 'Resources/lang'), 'customerlogin');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('CustomerLogin', 'Database/factories'));
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
            module_path('CustomerLogin', 'Config/config.php') => config_path('customerlogin.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('CustomerLogin', 'Config/config.php'),
            'customerlogin'
        );
    }
}
