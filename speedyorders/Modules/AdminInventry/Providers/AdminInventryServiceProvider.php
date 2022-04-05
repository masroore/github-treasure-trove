<?php

namespace Modules\AdminInventry\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminInventryServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminInventry', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/admininventry');

        $sourcePath = module_path('AdminInventry', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admininventry';
        }, Config::get('view.paths')), [$sourcePath]), 'admininventry');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/admininventry');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admininventry');
        } else {
            $this->loadTranslationsFrom(module_path('AdminInventry', 'Resources/lang'), 'admininventry');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminInventry', 'Database/factories'));
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
            module_path('AdminInventry', 'Config/config.php') => config_path('admininventry.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminInventry', 'Config/config.php'),
            'admininventry'
        );
    }
}
