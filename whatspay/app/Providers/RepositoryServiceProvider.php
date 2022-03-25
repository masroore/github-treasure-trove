<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\EloquentRepositoryInterface', 'App\Repositories\Eloquent\BaseRepository');

        $models = [
            'UserRepository', 'StoreRepository', 'IndustriesRepository', 'CategoryRepository',
            'BrandsRepository', 'TagsRepository', 'ProductLabelsRepository', 'ProductRepository',
            'AttributeRepository', 'VeriationRepository', 'VeriationItemsRepository', 'ShippingRepository',
            'RoleRepository', 'EmployeeRepository', 'ProductWithAttributeSetRepository', 'BranchRepository',
            'SizeChartRepository', 'CommentRepository', 'StoreBrandsRepository',
            'ShippingCompaniesRepository', 'ProductAddOnsRepository', 'ProductsCustomFieldsRepository',
            'ProductLabelProductsRepository', 'ProductTagsRepository', 'ProductVariationsRepository',
            'ProductVariationItemsRepository', 'ProductWithAttributeRepository', 'VoucherAssigneesRepository',
            'DealRepository', 'DealGroupsRepository', 'DealGroupDetailsRepository', 'DiscountVoucherRepository',
            'VoucherDetailsRepository', 'FavoritesRepository', 'AttributeSetRepository', 'OrderProductRepository', 'OrderPaymentsExtraDetailRepository',
            'OrderHistoriesRepository', 'OrdersRepository',
            'CardSessionRepository',
        ];

        foreach ($models as $model) {
            $this->app->bind("App\Repositories\\{$model}Interface", "App\Repositories\Eloquent\\{$model}");
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
