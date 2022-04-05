<?php

use Illuminate\Support\Facades\Route;

// routes with auth
Route::group(['middleware' => 'auth:sanctum'], function (): void {

    // store related routes
    Route::group(['prefix' => 'notification'], function (): void {
        Route::get('/', ['uses' => 'App\Http\Controllers\StoreController@notificationview', 'permission' => 'notification.view']);
        Route::delete('/{id}', ['uses' => 'App\Http\Controllers\StoreController@deletenoti', 'permission' => 'notification.delete']);
        Route::post('/{id}', ['uses' => 'App\Http\Controllers\StoreController@statuChange', 'permission' => 'notification.view']);
    });
    Route::get('/', ['uses' => 'App\Http\Controllers\StoreController@index', 'permission' => 'Store.view']);
    Route::put('/{id?}', ['uses' => 'App\Http\Controllers\StoreController@update', 'permission' => 'Store.edit']);
    Route::delete('/{ids}', ['uses' => 'App\Http\Controllers\StoreController@delete', 'permission' => 'Store.delete']);

    // Update Profile Image
    Route::post('/imageUpdate', ['uses' => 'App\Http\Controllers\StoreController@imageUpdate', 'permission' => 'Store.edit']);
    Route::post('/timings', ['uses' => 'App\Http\Controllers\StoreController@storeTimings', 'permission' => 'Store.timings']);
    Route::post('/settings', ['uses' => 'App\Http\Controllers\StoreController@settings', 'permission' => 'Store.timings']);

    // Labels routes

//    Route::resource('labels', ProductLabelsController::class);

    Route::group(['prefix' => 'labels'], function (): void {
        Route::get('/', ['uses' => 'App\Http\Controllers\ProductLabelsController@index', 'permission' => 'categories.view']);
        Route::post('/', ['uses' => 'App\Http\Controllers\ProductLabelsController@store', 'permission' => 'categories.add']);
        Route::get('/{label}', [
            'uses' => 'App\Http\Controllers\ProductLabelsController@show',
            'permission' => 'branches.view',
        ]);
        Route::put('/{label}', ['uses' => 'App\Http\Controllers\ProductLabelsController@update', 'permission' => 'categories.edit']);
        Route::delete('/{label}', ['uses' => 'App\Http\Controllers\ProductLabelsController@destroy', 'permission' => 'Store.delete']);
    });

    // Category routes

    Route::group(['prefix' => 'categories'], function (): void {
        Route::get('/', ['uses' => 'App\Http\Controllers\CategoryController@index', 'permission' => 'categories.view']);
        Route::post('/', ['uses' => 'App\Http\Controllers\CategoryController@store', 'permission' => 'categories.add']);
        Route::delete('/', ['uses' => 'App\Http\Controllers\CategoryController@destroy', 'permission' => 'categories.delete']);
        Route::put('/{category}', ['uses' => 'App\Http\Controllers\CategoryController@update', 'permission' => 'categories.edit']);
        Route::post('/bulk', ['uses' => 'App\Http\Controllers\CategoryController@destorybulk']);
        Route::put('/change-status/{id}', ['uses' => 'App\Http\Controllers\CategoryController@changeStatus', 'permission' => 'role.update']);
        Route::post('/productmigration', ['uses' => 'App\Http\Controllers\CategoryController@productMigration']);
    });

    //Branches routes
    Route::group(['prefix' => 'branches'], function (): void {
        Route::get('/', [
            'uses' => 'App\Http\Controllers\BranchController@index',
            'permission' => 'branches.view',
        ]);
        Route::post('/', [
            'uses' => 'App\Http\Controllers\BranchController@store',
            'permission' => 'branches.add',
        ]);
        Route::get('/{branch}', [
            'uses' => 'App\Http\Controllers\BranchController@show',
            'permission' => 'branches.view',
        ]);
        Route::delete('/{branch}', [
            'uses' => 'App\Http\Controllers\BranchController@destroy',
            'permission' => 'branches.delete',
        ]);

        Route::put('/{branch}', [
            'uses' => 'App\Http\Controllers\BranchController@update',
            'permission' => 'branches.edit',
        ]);

        Route::put('/{branch}/status', [
            'uses' => 'App\Http\Controllers\BranchController@status',
            'permission' => 'branches.edit',
        ]);

        Route::post('/timings/{branch}', [
            'uses' => 'App\Http\Controllers\BranchController@storeTimings',
            'permission' => 'Store.timings',
        ]);

        Route::post('/settings/{branch}', [
            'uses' => 'App\Http\Controllers\BranchController@settings',
            'permission' => 'Store.timings',
        ]);
    });

    //store product related routes
    Route::group(['prefix' => 'product'], function (): void {
        Route::delete('/{product}/image', ['uses' => 'App\Http\Controllers\ProductController@deleteImage', 'permission' => 'product.delete']);
        Route::post('/', ['uses' => 'App\Http\Controllers\ProductController@store', 'permission' => 'product.add']);
        Route::delete('/{product}', ['uses' => 'App\Http\Controllers\ProductController@destroy', 'permission' => 'product.delete']);
        Route::post('/{product}', ['uses' => 'App\Http\Controllers\ProductController@update', 'permission' => 'product.edit']);
        Route::get('/{product}', ['uses' => 'App\Http\Controllers\ProductController@show', 'permission' => 'product.view']);
        Route::get('/', ['uses' => 'App\Http\Controllers\ProductController@index', 'permission' => 'product.view']);
    });

    // shipping routes
    Route::group(['prefix' => 'shipping'], function (): void {
        Route::get('/', [
            'uses' => 'App\Http\Controllers\ShippingController@index',
            'permission' => 'shipping.view',
        ]);
        Route::post('/', [
            'uses' => 'App\Http\Controllers\ShippingController@store',
            'permission' => 'shipping.add',
        ]);
        Route::put('/{shipping}', [
            'uses' => 'App\Http\Controllers\ShippingController@update',
            'permission' => 'shipping.edit',
        ]);
        Route::get('/{shipping}', [
            'uses' => 'App\Http\Controllers\ShippingController@show',
            'permission' => 'shipping.view',
        ]);
        Route::delete('/{shipping}', [
            'uses' => 'App\Http\Controllers\ShippingController@destroy',
            'permission' => 'shipping.delete',
        ]);
    });

    // shipping companies routes
    Route::group(['prefix' => 'shippingcompanies'], function (): void {
        Route::get('/', [
            'uses' => 'App\Http\Controllers\ShippingCompaniesController@index',
            'permission' => 'shipping.view',
        ]);
        Route::post('/', [
            'uses' => 'App\Http\Controllers\ShippingCompaniesController@store',
            'permission' => 'shipping.add',
        ]);
        Route::post('/{shipping}', [
            'uses' => 'App\Http\Controllers\ShippingCompaniesController@update',
            'permission' => 'shipping.edit',
        ]);
        Route::get('/{shipping}', [
            'uses' => 'App\Http\Controllers\ShippingCompaniesController@show',
            'permission' => 'shipping.view',
        ]);
        Route::delete('/', [
            'uses' => 'App\Http\Controllers\ShippingCompaniesController@destroy',
            'permission' => 'shipping.delete',
        ]);
        Route::put('/{shipping}/status', [
            'uses' => 'App\Http\Controllers\ShippingCompaniesController@status',
            'permission' => 'shipping.edit',
        ]);
    });

    // product attributes routes
    Route::group(['prefix' => 'attribute-set'], function (): void {
        Route::post('/', ['uses' => 'App\Http\Controllers\AttributeSetController@store', 'permission' => 'attribute-set.add']);
        Route::get('/', ['uses' => 'App\Http\Controllers\AttributeSetController@index', 'permission' => 'attribute-set.view']);
        Route::delete('/{attribute}', ['uses' => 'App\Http\Controllers\AttributeSetController@destroy', 'permission' => 'attribute-set.delete']);
        Route::put('/{attribute}', ['uses' => 'App\Http\Controllers\AttributeSetController@update', 'permission' => 'attribute-set.edit']);
        Route::get('/{attribute}', ['uses' => 'App\Http\Controllers\AttributeSetController@show', 'permission' => 'attribute-set.view']);
    });

    // product attribute details routes
    Route::group(['prefix' => 'attributes'], function (): void {
        Route::post('/', ['uses' => 'App\Http\Controllers\AttributeController@store', 'permission' => 'attributes.add']);
        Route::get('/{attribute}/arrtibute-set', ['uses' => 'App\Http\Controllers\AttributeController@index', 'permission' => 'attributes.view']);
        Route::delete('/{attribute}', ['uses' => 'App\Http\Controllers\AttributeController@destroy', 'permission' => 'attributes.delete']);
        Route::put('/{attribute}', ['uses' => 'App\Http\Controllers\AttributeController@update', 'permission' => 'attributes.update']);
        Route::get('/{attribute}', ['uses' => 'App\Http\Controllers\AttributeController@show', 'permission' => 'attributes.view']);
    });

    Route::group(['prefix' => 'role'], function (): void {
        Route::post('/', ['uses' => 'App\Http\Controllers\RoleController@store', 'permission' => 'role.add']);
        Route::post('/{role}', ['uses' => 'App\Http\Controllers\RoleController@update', 'permission' => 'role.edit']);
        Route::get('/', ['uses' => 'App\Http\Controllers\RoleController@index', 'permission' => 'role.view']);
        Route::delete('/{role}', ['uses' => 'App\Http\Controllers\RoleController@destroy', 'permission' => 'role.delete']);
        Route::get('/{role}', ['uses' => 'App\Http\Controllers\RoleController@show', 'permission' => 'role.view']);
    });

    // GEt All permitions
    Route::group(['prefix' => 'permissions'], function (): void {
        Route::get('/', [
            'uses' => function () {
                $data = config('permissions');

                return response()->json([$data]);
            }, 'permission' => false, ]);
    });

    //helper for multi images

    Route::get('testtest', ['uses' => 'App\Http\Controllers\RoleController@show', 'permission' => 'role.view']);
    // product attribute details routes
    Route::group(['prefix' => 'employee'], function (): void {
        Route::get('/', ['uses' => 'App\Http\Controllers\EmployeeController@index', 'permission' => 'role.view']);
        Route::post('/', ['uses' => 'App\Http\Controllers\EmployeeController@store', 'permission' => 'role.add']);
        Route::get('/{id}', ['uses' => 'App\Http\Controllers\EmployeeController@show', 'permission' => 'role.view']);
        Route::put('/{id}', ['uses' => 'App\Http\Controllers\EmployeeController@update', 'permission' => 'role.update']);
        Route::delete('/{id}', ['uses' => 'App\Http\Controllers\EmployeeController@destroy', 'permission' => 'role.delete']);
    });
    // product attribute details routes
    Route::group(['prefix' => 'sizechart'], function (): void {
        Route::get('/', ['uses' => 'App\Http\Controllers\SizeChartController@index', 'permission' => 'role.view']);
        Route::post('/', ['uses' => 'App\Http\Controllers\SizeChartController@store', 'permission' => 'role.add']);
        Route::get('/{id}', ['uses' => 'App\Http\Controllers\SizeChartController@show', 'permission' => 'role.view']);
        Route::post('/{id}', ['uses' => 'App\Http\Controllers\SizeChartController@update', 'permission' => 'role.update']);
        Route::put('/{id}', ['uses' => 'App\Http\Controllers\SizeChartController@changeStatus', 'permission' => 'role.update']);
        Route::delete('/{id}', ['uses' => 'App\Http\Controllers\SizeChartController@destroy', 'permission' => 'role.delete']);
    });
    // store brands routes
    Route::group(['prefix' => 'brands'], function (): void {
        Route::get('/', [
            'uses' => 'App\Http\Controllers\StoreBrandsController@index',
            'permission' => 'brands.view',
        ]);

        Route::post('/', [
            'uses' => 'App\Http\Controllers\StoreBrandsController@store',
            'permission' => 'brands.update',
        ]);

        Route::post('/status', [
            'uses' => 'App\Http\Controllers\StoreBrandsController@updateMultiple',
            'permission' => 'brands.update',
        ]);
    });
    // store voucher routes
    Route::group(['prefix' => 'voucher'], function (): void {
        Route::get('/', ['uses' => 'App\Http\Controllers\DiscountVoucherController@index', 'permission' => 'voucher.view']);
        Route::get('/{voucher}', ['uses' => 'App\Http\Controllers\DiscountVoucherController@show', 'permission' => 'voucher.view']);
        Route::post('/', ['uses' => 'App\Http\Controllers\DiscountVoucherController@store', 'permission' => 'voucher.add']);
        Route::post('/{voucher}', ['uses' => 'App\Http\Controllers\DiscountVoucherController@update', 'permission' => 'voucher.edit']);
        Route::delete('/{voucher}', ['uses' => 'App\Http\Controllers\DiscountVoucherController@destroy', 'permission' => 'voucher.delete']);
    });
    // store deal routes
    Route::group(['prefix' => 'deal'], function (): void {
        Route::get('/', ['uses' => 'App\Http\Controllers\DealController@index', 'permission' => 'deal.view']);
        Route::get('/{deal}', ['uses' => 'App\Http\Controllers\DealController@show', 'permission' => 'deal.view']);
        Route::post('/', ['uses' => 'App\Http\Controllers\DealController@store', 'permission' => 'deal.add']);
        Route::delete('/group/{id}', ['uses' => 'App\Http\Controllers\DealController@groupDelete', 'permission' => 'deal.delete']);
        Route::delete('/choice/{id}', ['uses' => 'App\Http\Controllers\DealController@choiceDelete', 'permission' => 'deal.delete']);
        Route::post('/{deal}', ['uses' => 'App\Http\Controllers\DealController@update', 'permission' => 'deal.edit']);
        Route::delete('/{deal}', ['uses' => 'App\Http\Controllers\DealController@destroy', 'permission' => 'deal.delete']);
    });
    // store order routes
    Route::group(['prefix' => 'order'], function (): void {
        Route::get('/order-filter', ['uses' => 'App\Http\Controllers\OrderController@orderFliter', 'permission' => 'order.view']);
        Route::get('/', ['uses' => 'App\Http\Controllers\OrderController@ordersStore', 'permission' => 'order.view']);
        Route::post('/update-status', ['uses' => 'App\Http\Controllers\OrderController@statusUpdate', 'permission' => 'order.update']);
        Route::get('/{order}', ['uses' => 'App\Http\Controllers\OrderController@show', 'permission' => 'order.view']);
        Route::delete('/{order}', ['uses' => 'App\Http\Controllers\OrderController@destroy', 'permission' => 'order.delete']);
    });
});
