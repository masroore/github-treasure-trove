<?php

namespace Modules\AdminCustomer\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminCustomerServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminCustomer', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/admincustomer');

        $sourcePath = module_path('AdminCustomer', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admincustomer';
        }, Config::get('view.paths')), [$sourcePath]), 'admincustomer');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/admincustomer');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admincustomer');
        } else {
            $this->loadTranslationsFrom(module_path('AdminCustomer', 'Resources/lang'), 'admincustomer');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminCustomer', 'Database/factories'));
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
            module_path('AdminCustomer', 'Config/config.php') => config_path('admincustomer.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminCustomer', 'Config/config.php'),
            'admincustomer'
        );
    }
}
