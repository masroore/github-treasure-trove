<?php

namespace Modules\Logdumper\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class LogdumperServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Logdumper', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/logdumper');

        $sourcePath = module_path('Logdumper', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/logdumper';
        }, Config::get('view.paths')), [$sourcePath]), 'logdumper');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/logdumper');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'logdumper');
        } else {
            $this->loadTranslationsFrom(module_path('Logdumper', 'Resources/lang'), 'logdumper');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Logdumper', 'Database/factories'));
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
            module_path('Logdumper', 'Config/config.php') => config_path('logdumper.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Logdumper', 'Config/config.php'),
            'logdumper'
        );
    }
}
