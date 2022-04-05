<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Admin routes.
 */
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'permission:dashboard.read']], function (): void {
    Route::get('/', 'AdminController@home')->name('home');
    Route::get('account', 'AccountController@edit')->name('account.edit');
    Route::patch('account', 'AccountController@update')->name('account.update');

    Route::group(['namespace' => 'Taxonomy'], function (): void {
        Route::resource('vocabularies', 'VocabularyController', ['except' => ['show']]);
        Route::resource('terms', 'TermController', ['except' => ['show']]);
        Route::post('terms/order', 'TermController@order')->name('terms.order');
        Route::get('terms/autocomplete', 'TermController@autocomplete')->name('terms.autocomplete');
        Route::get('terms/treeselect', 'TermController@treeselect')->name('terms.treeselect');
        Route::get('terms/treeview', 'TermController@treeview')->name('terms.treeview');
        Route::get('terms/{id}/seo', 'TermController@seo')->name('terms.seo');
        Route::post('terms/{id}/seo', 'TermController@seoSave')->name('terms.seo.save');
    });

    Route::group(['namespace' => 'Menu'], function (): void {
        Route::resource('menu', 'MenuController', ['except' => ['show']]);
        Route::resource('menu-items', 'MenuItemController');
        Route::post('menu-items/order', 'MenuItemController@order')->name('menu-items.order');
    });

    Route::group(['namespace' => 'Shop'], function (): void {
        Route::resource('colors', 'ColorController', ['except' => ['show']]);

        Route::resource('products', 'ProductController', ['except' => ['show']]);
        Route::get('products/autocomplete', 'ProductController@autocomplete')->name('products.autocomplete');
        Route::delete('products/group/{id}', 'ProductController@groupDestroy')->name('products.group.destroy');
        Route::post('products/{id}/default-group', 'ProductController@groupDefaultProduct')->name('products.group.default');
        Route::get('products/{id}/values', 'ProductController@values')->name('products.values');
        Route::post('products/{id}/values', 'ProductController@valuesSave')->name('products.values.save');
        Route::get('products/{id}/seo', 'ProductController@seo')->name('products.seo');
        Route::post('products/{id}/seo', 'ProductController@seoSave')->name('products.seo.save');

        Route::get('product-reviews', 'ProductReviewController@index')->name('product-reviews.index');
        Route::post('product-reviews/{id}/editable', 'ProductReviewController@editable')->name('product-reviews.editable');
        Route::match(['POST', 'GET'], 'product-reviews/{id}/status', 'ProductReviewController@status')->name('product-reviews.status'); // TODO only POST!
        Route::delete('product-reviews/{id}', 'ProductReviewController@destroy')->name('product-reviews.destroy');

        Route::resource('sales', 'SaleController', ['except' => ['show']]);
        Route::get('sales/{id}/options', 'SaleController@options')->name('sales.options');
        Route::post('sales/{id}/options', 'SaleController@optionsSave')->name('sales.options.save');
        Route::get('sales/{id}/seo', 'SaleController@seo')->name('sales.seo');
        Route::post('sales/{id}/seo', 'SaleController@seoSave')->name('sales.seo.save');

        Route::post('sale-promo-codes', 'SalePromoCodeController@store')->name('sale-promo-codes.store');
        Route::post('sale-promo-codes/generate', 'SalePromoCodeController@generate')->name('sale-promo-codes.generate');
        Route::delete('sale-promo-codes/{id}', 'SalePromoCodeController@destroy')->name('sale-promo-codes.destroy');
        Route::post('sale-promo-codes/{id}/editable', 'SalePromoCodeController@editable')->name('sale-promo-codes.editable');

        Route::resource('orders', 'OrderController', ['except' => ['show']]);
        Route::delete('orders/{order}/product/{id}', 'OrderController@productDestroy')->name('orders.product.destroy');
        Route::get('orders/{id}/print', 'OrderController@printed')->name('orders.print');

        Route::resource('shop/attributes', 'AttributeController');
        Route::post('shop/attributes/{id}/editable', 'AttributeController@editable')->name('shop.attributes.editable');
        Route::resource('shop/values', 'ValueController');
        Route::post('shop/values/{id}/editable', 'ValueController@editable')->name('shop.values.editable');
    });

    Route::resource('users', 'UserController', ['except' => ['show']]);

    Route::resource('news', 'NewsController', ['except' => ['show']]);
    Route::get('news/{id}/seo', 'NewsController@seo')->name('news.seo');
    Route::post('news/{id}/seo', 'NewsController@seoSave')->name('news.seo.save');

    Route::resource('pages', 'PageController', ['except' => ['show']]);
    Route::get('pages/{id}/seo', 'PageController@seo')->name('pages.seo');
    Route::post('pages/{id}/seo', 'PageController@seoSave')->name('pages.seo.save');

    Route::group([], function (): void {
        Route::get('forms/{type}', 'FormController@index')->name('forms.index');
        Route::delete('forms/{id}', 'FormController@destroy')->name('forms.destroy');
        Route::post('form/{id}/editable', 'FormController@editable')->name('forms.editable');
        Route::match(['POST', 'GET'], 'forms/{id}/status', 'FormController@status')->name('forms.status'); // TODO only POST!
    });

    Route::group(['namespace' => 'Seo'], function (): void {
        Route::resource('url-aliases', 'UrlAliasController', ['only' => ['index', 'store', 'destroy']]);
        Route::get('url-aliases/autocomplete', 'UrlAliasController@autocomplete')->name('url-aliases.autocomplete'); // TODO: rename
        Route::resource('meta-tags', 'MetaTagController', ['except' => ['show']]);
        Route::get('site-map', 'SiteMapController@edit')->name('site-map.edit');
        Route::post('site-map', 'SiteMapController@update')->name('site-map.update');
        Route::post('site-map/generate', 'SiteMapController@regenerate')->name('site-map.regenerate');
        Route::delete('site-map', 'SiteMapController@destroy')->name('site-map.destroy');
    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('variables', 'VariableController@forms')->name('variable.forms');
    Route::post('variables', 'VariableController@save')->name('variable.save');
    Route::get('cache-clear', 'ServiceController@cache')->name('service.cache-clear');
    Route::get('variables/dd', function (): void {
        //dd(\Fomvasss\Variable\Models\Variable::get()->toArray());
        \Fomvasss\Variable\Models\Variable::where('key', 'LIKE', '%external%')->orWhere('key', 'LIKE', '%xml%')->orWhere('key', 'LIKE', '%bitrix24%')->update(['locale' => null]);
        \Fomvasss\Variable\Models\Variable::where('key', 'front_code_end_body')->orWhere('key', 'front_code_start_body')->orWhere('key', 'front_code_in_head')->update(['locale' => null]);
    });
});
//Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['middleware' => 'setlocale'], function (): void {
    /**
     * Auth routes.
     * https://github.com/laravel/framework/blob/5.7/src/Illuminate/Routing/Router.php.
     */
    Auth::routes(['verify' => true]);

    /**
     * This is start page for users.
     */
    Route::get('start', function (Illuminate\Http\Request $request) {
        if ($request->user()->hasRole('admin') || $request->user()->hasPermissionTo('dashboard.home.read')) {
            return redirect()->route('admin.home');
        } elseif ($request->user()->hasPermissionTo('client-account.read')) {
            return redirect()->to(app()->getLocale() . '/account');
        }

        return redirect()->to(app()->getLocale() . '/');
    })->name('start')->middleware('auth');

    /**
     * Front routes.
     */
    Route::group(['namespace' => 'Front'], function (): void {
        Route::get('account', 'AccountController@edit')->name('account.edit');
        Route::post('account', 'AccountController@update')->name('account.update');
        Route::get('account/history', 'AccountController@history')->name('account.history');
        Route::get('account/favorites', 'AccountController@favorites')->name('account.favorites');

        Route::get('search', 'Shop\ProductController@search')->name('product.search');
        Route::get('product/{id}', 'Shop\ProductController@product')->name('product.show');

        Route::post('product/color-clear', 'Shop\ProductController@colorClear')->name('product.color-clear');
        Route::post('product/update-product', 'Shop\ProductController@updateProduct')->name('product.update-product');
        Route::post('product/update-count', 'Shop\ProductController@updateProductCount')->name('product.update-count');
        Route::post('product/update-product-group', 'Shop\ProductController@updateProductGroup')->name('product.update-product-group');
        Route::post('product/product-color', 'Shop\ProductController@productColor')->name('product.product-color');

        Route::get('category/{id}', 'Shop\ProductController@category')->name('category.show');
        Route::get('productions', 'Shop\ProductController@categories')->name('category.index');
        Route::get('news', 'NewsController@index')->name('news.index');
        Route::get('node-news/{id}', 'NewsController@show')->name('news.show');

        //Route::get('product-review', 'Shop\ProductReviewController@index')->name('product-review.index');
        Route::post('product-review', 'Shop\ProductReviewController@store')->name('product-review.store')->middleware(['auth', 'throttle']);

        Route::get('sale/{id}', 'Shop\SaleController@show')->name('sale.show');
        Route::get('sales', 'Shop\SaleController@index')->name('sale.index');

        Route::group(['middleware' => 'throttle'], function (): void {
            Route::post('product-favorite/{id}', 'Shop\ProductFavoriteController@toggle')->name('product-favorite.toggle');
            Route::post('product-favorite/{id}/add', 'Shop\ProductFavoriteController@add')->name('product-favorite.add');
            Route::post('product-favorite/{id}/remove', 'Shop\ProductFavoriteController@remove')->name('product-favorite.remove');

            Route::get('cart', 'Shop\ShoppingCartController@index')->name('shopping-cart.index');
            Route::post('cart/clear', 'Shop\ShoppingCartController@clear')->name('shopping-cart.clear');
            Route::post('cart/form', 'Shop\ShoppingCartController@form')->name('shopping-cart.form');
            Route::post('cart/order', 'Shop\ShoppingCartController@order')->name('shopping-cart.order');
            Route::post('cart/{id}/add/{amount?}', 'Shop\ShoppingCartController@add')->name('shopping-cart.add');
            Route::post('cart/{id}/remove/{amount?}', 'Shop\ShoppingCartController@remove')->name('shopping-cart.remove');
            Route::post('cart/order-now', 'Shop\ShoppingCartController@orderNow')->name('shopping-cart.order-now');

//            Route::post('cart/update-product', 'Shop\ShoppingCartController@updateProduct')->name('shopping-cart.update-product');

            Route::post('cart/add-to-cart', 'Shop\ShoppingCartController@addToCart')->name('shopping-cart.add-to-cart');
//            Route::delete('cart/remove-from-cart', 'Shop\ShoppingCartController@removeFromCart')->name('shopping-cart.remove-from-cart');

            Route::post('form', 'FormController@store')->name('form.store'); //->middleware('protect_against_spam');
        });

        Route::get('page/{id}', 'PageController@show')->name('page.show');
        //Route::get('/', 'PageController@home')->name('home');
        Route::get('/{locale?}', 'PageController@home')->name('home')->middleware('applyUrlLocaleToRootPage');
    });
});

Route::get('/test', function (Illuminate\Http\Request $request) {
    return 'OK';
});
