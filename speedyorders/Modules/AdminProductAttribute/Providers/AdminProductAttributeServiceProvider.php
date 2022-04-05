<?php

namespace Modules\AdminProductAttribute\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminProductAttributeServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminProductAttribute', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminproductattribute');

        $sourcePath = module_path('AdminProductAttribute', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminproductattribute';
        }, Config::get('view.paths')), [$sourcePath]), 'adminproductattribute');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/adminproductattribute');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminproductattribute');
        } else {
            $this->loadTranslationsFrom(module_path('AdminProductAttribute', 'Resources/lang'), 'adminproductattribute');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminProductAttribute', 'Database/factories'));
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
            module_path('AdminProductAttribute', 'Config/config.php') => config_path('adminproductattribute.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminProductAttribute', 'Config/config.php'),
            'adminproductattribute'
        );
    }
}
