<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'product', 'middleware' => ['auth']], function (): void {
    Route::get('/unit-type/csv-upload-page', 'UnitTypeController@csv_upload')->name('unit_type.csv_upload');
    Route::post('/unit-type/csv-upload-store', 'UnitTypeController@csv_upload_store')->name('unit_type.csv_upload_store');
    Route::get('/brand/csv-upload-page', 'BrandController@csv_upload')->name('brand.csv_upload');
    Route::post('/brand/csv-upload-store', 'BrandController@csv_upload_store')->name('brand.csv_upload_store');
    Route::get('/model/csv-upload-page', 'ModelController@csv_upload')->name('model.csv_upload');
    Route::post('/model/csv-upload-store', 'ModelController@csv_upload_store')->name('model.csv_upload_store');
    Route::get('/brand/csv-download', 'BrandController@csv_download')->name('brand.csv_download');
    Route::get('/model/csv-download', 'ModelController@csv_download')->name('model.csv_download');
    Route::get('/unit-type/csv-download', 'UnitTypeController@csv_download')->name('unit_type.csv_download');

    Route::get('/unit_type/get_list', 'UnitTypeController@create')->name('unit_type.get_list');
    Route::get('/brand/get_list', 'BrandController@create')->name('brand.get_list');
    Route::get('/model/get_list', 'ModelController@create')->name('model.get_list');
    Route::get('/category/get_list', 'CategoryController@create')->name('category.get_list');
    Route::get('/variant/get_list', 'VariantController@create')->name('variant.get_list');

    Route::middleware('permission')->group(function (): void {
        Route::get('/unit_type/{id}/delete', 'UnitTypeController@destroy')->name('unit_type.delete');
        Route::resource('/unit_type', 'UnitTypeController');

        Route::get('/brand/{id}/delete', 'BrandController@destroy')->name('brand.delete');
        Route::resource('/brand', 'BrandController');

        Route::get('/model/{id}/delete', 'ModelController@destroy')->name('model.delete');
        Route::resource('/model', 'ModelController');

        Route::get('/category/{id}/delete', 'CategoryController@destroy')->name('category.delete');
        Route::resource('/category', 'CategoryController');

        Route::get('/variant/{id}/delete', 'VariantController@destroy')->name('variant.delete');
        Route::resource('/variant', 'VariantController');
    });

    Route::get('/{id}/serial-keys', 'ProductController@serial_key_index')->name('add_product.serial_key');

    Route::get('/{id}/selling-price-history', 'ProductController@selling_price_history')->name('add_product.selling_price_history');

    //variant
    Route::get('/variation_list/{variant}', 'ProductController@variation_list')->name('variation_list');
    Route::get('/variant_with_values/{variant}', 'ProductController@variant_with_values')->name('variant_with_values');

    Route::get('/parent_category', 'CategoryController@parent_category')->name('category.parent');

    //----Products----

    Route::middleware('permission')->group(function (): void {
        Route::get('/add_product/service', 'ProductController@service')->name('add_product.service');
        Route::get('/csv-upload-page', 'ProductController@csv_upload')->name('add_product.csv_upload');
        Route::post('/csv-upload-store', 'ProductController@csv_upload_store')->name('add_product.csv_upload_store');
        Route::resource('/add_product', 'ProductController')->except('destroy');
        Route::post('/view', 'ProductController@product_Detail')->name('add_product.product_Detail');
        Route::get('/print-labels', 'ProductController@printLabels')->name('print.labels');
        Route::post('/search_product', 'ProductController@searchProduct')->name('search.product');
        Route::get('/delete/{id}', 'ProductController@destroy')->name('add_product.destroy');
        Route::get('/combo-edit/{id}', 'ProductController@show')->name('add_product.editCombo');
        Route::get('/combo-delete/{id}', 'ProductController@destroyCombo')->name('combo_product.destroy');
        Route::post('/combo-status', 'ProductController@comboStatus')->name('combo_product.update_active_status');
    });

    Route::get('/add-opening-stock', 'ProductController@add_opening_stock_create')->name('add_opening_stock_create')->prefix('inventory');
    Route::post('/product-details-for-stock', 'ProductController@productDetailForStock')->name('product-details-for-stock');
    Route::post('/product-details-for-stock-packing', 'ProductController@productDetailForPacking')->name('product-details-for-stock-packing');

    Route::get('/search-products', 'ProductController@create')->name('add_product.search_index');
    Route::post('/get-price-product-sku', 'ProductController@product_sku_get_price')->name('product_sku.get_product_price');
    Route::get('/category_wise_subcategory/{category}', 'ProductController@category_wise_subcategory');
    //----End Products----

    // Ajax api
    Route::get('/unit_type_all', 'UnitTypeController@getAll')->name('unit.all');
    Route::get('/brand_all', 'BrandController@getAll')->name('brand.all');
    Route::get('/model_all', 'ModelController@getAll')->name('model.all');
    Route::get('/category_all', 'CategoryController@getAll')->name('category.all');
    Route::get('/sub_category_all', 'CategoryController@allSubCategory')->name('sub_category.all');
});

Route::prefix('coupons')->group(function (): void {
    Route::get('/lists', 'CouponController@index')->name('coupon.index');
    Route::get('/destroy', 'CouponController@destroy')->name('coupon.destroy');
    Route::post('/store', 'CouponController@store')->name('coupon.store');
    Route::post('/edit', 'CouponController@edit')->name('coupon.edit');
    Route::post('/{id}/update', 'CouponController@update')->name('coupon.update');
});
