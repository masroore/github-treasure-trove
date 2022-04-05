<?php

namespace Modules\AdminStateTax\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminStateTaxServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminStateTax', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminstatetax');

        $sourcePath = module_path('AdminStateTax', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminstatetax';
        }, Config::get('view.paths')), [$sourcePath]), 'adminstatetax');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/adminstatetax');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminstatetax');
        } else {
            $this->loadTranslationsFrom(module_path('AdminStatetax', 'Resources/lang'), 'adminstatetax');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminStatetax', 'Database/factories'));
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
            module_path('AdminStateTax', 'Config/config.php') => config_path('adminstatetax.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminStateTax', 'Config/config.php'),
            'adminstatetax'
        );
    }
}
