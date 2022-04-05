<?php

namespace Modules\AdminShipping\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminShippingServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminShipping', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminshipping');

        $sourcePath = module_path('AdminShipping', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminshipping';
        }, Config::get('view.paths')), [$sourcePath]), 'adminshipping');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/adminshipping');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminshipping');
        } else {
            $this->loadTranslationsFrom(module_path('AdminShipping', 'Resources/lang'), 'adminshipping');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminShipping', 'Database/factories'));
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
            module_path('AdminShipping', 'Config/config.php') => config_path('adminshipping.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminShipping', 'Config/config.php'),
            'adminshipping'
        );
    }
}
