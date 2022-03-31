<?php

namespace Modules\AdminProductQuestion\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminProductQuestionServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminProductQuestion', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminproductquestion');

        $sourcePath = module_path('AdminProductQuestion', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminproductquestion';
        }, \Config::get('view.paths')), [$sourcePath]), 'adminproductquestion');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/adminproductquestion');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminproductquestion');
        } else {
            $this->loadTranslationsFrom(module_path('AdminProductQuestion', 'Resources/lang'), 'adminproductquestion');
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
            app(Factory::class)->load(module_path('AdminProductQuestion', 'Database/factories'));
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
            module_path('AdminProductQuestion', 'Config/config.php') => config_path('adminproductquestion.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminProductQuestion', 'Config/config.php'),
            'adminproductquestion'
        );
    }
}
