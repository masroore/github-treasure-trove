<?php

namespace Modules\AdminReview\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class AdminReviewServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('AdminReview', 'Database/Migrations'));
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
        $viewPath = resource_path('views/modules/adminreview');

        $sourcePath = module_path('AdminReview', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminreview';
        }, Config::get('view.paths')), [$sourcePath]), 'adminreview');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/adminreview');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminreview');
        } else {
            $this->loadTranslationsFrom(module_path('AdminReview', 'Resources/lang'), 'adminreview');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('AdminReview', 'Database/factories'));
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
            module_path('AdminReview', 'Config/config.php') => config_path('adminreview.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('AdminReview', 'Config/config.php'),
            'adminreview'
        );
    }
}
