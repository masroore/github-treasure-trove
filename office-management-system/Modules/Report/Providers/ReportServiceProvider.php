<?php

namespace Modules\Report\Providers;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Report\Repositories\BalanceStatementReportRepository;
use Modules\Report\Repositories\BalanceStatementReportRepositoryInterface;
use Modules\Report\Repositories\CashFlowReportRepository;
use Modules\Report\Repositories\CashFlowReportRepositoryInterface;
use Modules\Report\Repositories\IncomeStatementReportRepository;
use Modules\Report\Repositories\IncomeStatementReportRepositoryInterface;
use Modules\Report\Repositories\LedgerReportRepository;
use Modules\Report\Repositories\LedgerReportRepositoryInterface;
use Modules\Report\Repositories\PurchaseReportRepository;
use Modules\Report\Repositories\PurchaseReportRepositoryInterface;
use Modules\Report\Repositories\ReportRepository;
use Modules\Report\Repositories\ReportRepositoryInterface;
use Modules\Report\Repositories\SalesReportRepository;
use Modules\Report\Repositories\SalesReportRepositoryInterface;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Report';

    /**
     * @var string
     */
    protected $moduleNameLower = 'report';

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
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(SalesReportRepositoryInterface::class, SalesReportRepository::class);
        $this->app->bind(LedgerReportRepositoryInterface::class, LedgerReportRepository::class);
        $this->app->bind(PurchaseReportRepositoryInterface::class, PurchaseReportRepository::class);
        $this->app->bind(CashFlowReportRepositoryInterface::class, CashFlowReportRepository::class);
        $this->app->bind(IncomeStatementReportRepositoryInterface::class, IncomeStatementReportRepository::class);
        $this->app->bind(BalanceStatementReportRepositoryInterface::class, BalanceStatementReportRepository::class);
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
