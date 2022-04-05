<?php

namespace Modules\AdminCategory\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminCategoryServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminCategory', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/admincategory');

        $sourcePath = module_path('AdminCategory', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admincategory';
        }, Config::get('view.paths')), [$sourcePath]), 'admincategory');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/admincategory');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admincategory');
        } else {
            $this->loadTranslationsFrom(module_path('AdminCategory', 'Resources/lang'), 'admincategory');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminCategory', 'Database/factories'));
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
            module_path('AdminCategory', 'Config/config.php') => config_path('admincategory.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminCategory', 'Config/config.php'),
            'admincategory'
        );
    }
}
