<?php

namespace Modules\Product\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Repositories\BrandRepository;
use Modules\Product\Repositories\BrandRepositoryInterface;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Repositories\CategoryRepositoryInterface;
use Modules\Product\Repositories\CouponRepository;
use Modules\Product\Repositories\CouponRepositoryInterface;
use Modules\Product\Repositories\ModelTypeRepository;
use Modules\Product\Repositories\ModelTypeRepositoryInterface;
use Modules\Product\Repositories\PriceGroupRepository;
use Modules\Product\Repositories\PriceGroupRepositoryInterface;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Modules\Product\Repositories\UnitTypeRepository;
use Modules\Product\Repositories\UnitTypeRepositoryInterface;
use Modules\Product\Repositories\VariantRepository;
use Modules\Product\Repositories\VariantRepositoryInterface;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Product';

    /**
     * @var string
     */
    protected $moduleNameLower = 'product';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(VariantRepositoryInterface::class, VariantRepository::class);
        $this->app->bind(UnitTypeRepositoryInterface::class, UnitTypeRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ModelTypeRepositoryInterface::class, ModelTypeRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(PriceGroupRepositoryInterface::class, PriceGroupRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories(): void
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path($this->moduleName, 'Database/factories'));
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

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }

        return $paths;
    }
}
