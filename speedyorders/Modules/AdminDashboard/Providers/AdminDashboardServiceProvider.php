<?php

namespace Modules\AdminDashboard\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminDashboardServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminDashboard', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/admindashboard');

        $sourcePath = module_path('AdminDashboard', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admindashboard';
        }, Config::get('view.paths')), [$sourcePath]), 'admindashboard');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/admindashboard');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admindashboard');
        } else {
            $this->loadTranslationsFrom(module_path('AdminDashboard', 'Resources/lang'), 'admindashboard');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminDashboard', 'Database/factories'));
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
            module_path('AdminDashboard', 'Config/config.php') => config_path('admindashboard.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminDashboard', 'Config/config.php'),
            'admindashboard'
        );
    }
}
