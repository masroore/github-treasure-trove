<?php

namespace Modules\AdminSetting\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminSettingServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminSetting', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminsetting');

        $sourcePath = module_path('AdminSetting', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminsetting';
        }, Config::get('view.paths')), [$sourcePath]), 'adminsetting');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/adminsetting');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminsetting');
        } else {
            $this->loadTranslationsFrom(module_path('AdminSetting', 'Resources/lang'), 'adminsetting');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminSetting', 'Database/factories'));
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
            module_path('AdminSetting', 'Config/config.php') => config_path('adminsetting.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminSetting', 'Config/config.php'),
            'adminsetting'
        );
    }
}
