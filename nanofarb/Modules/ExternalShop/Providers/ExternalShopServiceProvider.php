<?php

namespace Modules\ExternalShop\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\ExternalShop\Events\OrderCreated;
use Modules\ExternalShop\Listeners\NotifyOfOrderCreated;

class ExternalShopServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('ExternalShop', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app['events']->listen(OrderCreated::class, NotifyOfOrderCreated::class);
    }

    protected function registerCommands(): void
    {
        $this->commands([
            \Modules\ExternalShop\Console\GetOrders::class,
        ]);
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path('ExternalShop', 'Config/config.php') => config_path('externalshop.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('ExternalShop', 'Config/config.php'),
            'externalshop'
        );
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/externalshop');

        $sourcePath = module_path('ExternalShop', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/externalshop';
        }, Config::get('view.paths')), [$sourcePath]), 'externalshop');
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/externalshop');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'externalshop');
        } else {
            $this->loadTranslationsFrom(module_path('ExternalShop', 'Resources/lang'), 'externalshop');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('ExternalShop', 'Database/factories'));
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
}
