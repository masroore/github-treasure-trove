<?php

namespace Modules\EmailTemplate\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class EmailTemplateServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('EmailTemplate', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/emailtemplate');

        $sourcePath = module_path('EmailTemplate', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/emailtemplate';
        }, Config::get('view.paths')), [$sourcePath]), 'emailtemplate');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/emailtemplate');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'emailtemplate');
        } else {
            $this->loadTranslationsFrom(module_path('EmailTemplate', 'Resources/lang'), 'emailtemplate');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('EmailTemplate', 'Database/factories'));
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
            module_path('EmailTemplate', 'Config/config.php') => config_path('emailtemplate.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('EmailTemplate', 'Config/config.php'),
            'emailtemplate'
        );
    }
}
