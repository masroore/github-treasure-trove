<?php

namespace Modules\AdminProduct\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminProductServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminProduct', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminproduct');

        $sourcePath = module_path('AdminProduct', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminproduct';
        }, \Config::get('view.paths')), [$sourcePath]), 'adminproduct');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/adminproduct');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminproduct');
        } else {
            $this->loadTranslationsFrom(module_path('AdminProduct', 'Resources/lang'), 'adminproduct');
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
            app(Factory::class)->load(module_path('AdminProduct', 'Database/factories'));
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
            module_path('AdminProduct', 'Config/config.php') => config_path('adminproduct.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminProduct', 'Config/config.php'),
            'adminproduct'
        );
    }
}
