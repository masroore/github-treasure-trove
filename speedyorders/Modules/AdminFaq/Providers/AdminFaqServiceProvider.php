<?php

namespace Modules\AdminFaq\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminFaqServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminFaq', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminfaq');

        $sourcePath = module_path('AdminFaq', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminfaq';
        }, Config::get('view.paths')), [$sourcePath]), 'adminfaq');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/adminfaq');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminfaq');
        } else {
            $this->loadTranslationsFrom(module_path('AdminFaq', 'Resources/lang'), 'adminfaq');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminFaq', 'Database/factories'));
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
            module_path('AdminFaq', 'Config/config.php') => config_path('adminfaq.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminFaq', 'Config/config.php'),
            'adminfaq'
        );
    }
}
