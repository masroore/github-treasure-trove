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
Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('clear_cache', function (): void {
    \Artisan::call('optimize:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');

    dd('Cache is cleared');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MoneySetupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PayPalPaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/delivery', [HomeController::class, 'delivery'])->name('delivery');
Route::post('/payment', [MoneySetupController::class, 'stripe'])->name('payment');

Route::get('/payment', [MoneySetupController::class, 'payment'])->name('payment');
Route::get('/payment', [HomeController::class, 'payment'])->name('payment');

Route::get('/receipt', [HomeController::class, 'receipt'])->name('receipt');

// Frontend products related
Route::get('/categories', [ProductController::class, 'getCategories'])->name('categories');

 Route::get('/store/{category_slug?}', [ProductController::class, 'index'])->name('store');
 Route::post('search_products', [ProductController::class, 'searchProducts'])->name('search_products');
 Route::get('/category-products/{category_slug?}', [ProductController::class, 'getProducts'])->name('product-listings');

// frontend pages
 Route::get('/support', [PageController::class, 'support'])->name('support');
 Route::get('/faq', [PageController::class, 'faq'])->name('faq');
 Route::get('/wishlist', [PageController::class, 'wishlist'])->name('wishlist');

 Route::get('/blog', [PageController::class, 'blog'])->name('blog');
 Route::get('/site-map', [PageController::class, 'site_map'])->name('site_map');
 Route::get('/trendings', [PageController::class, 'trendings'])->name('trendings');
 Route::get('/promotions', [PageController::class, 'promotions'])->name('promotions');
 Route::get('/b2b_home', [PageController::class, 'b2b_home'])->name('b2b_home');

Route::group(['prefix' => '/pages/'], function (): void {
    Route::get('/{slug}', [PageController::class, 'getCmsPageDetails']);
});

//Route::get('/product-details/{id}', [HomeController::class, 'getProductDetails'])->name('product-details');
Route::get('/product-details/{slug?}', [HomeController::class, 'getProductDetails'])->name('product-details');

//Route::get('products/{product:slug}', [HomeController::class, 'getProductDetails'])->name('product-details'); // Finds product by slug.

Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');

Route::post('/addtocart', [HomeController::class, 'addToCart'])->name('addtocart');
Route::post('/removefromcart', [HomeController::class, 'removeFromCart'])->name('removefromcart');
Route::post('/updateProductQty', [HomeController::class, 'updateProductQty'])->name('updateProductQty');
Route::post('/updateToSearch', [HomeController::class, 'updateToSearch'])->name('updatetosearch');

if ('production' == config('app.env')) {
    URL::forceScheme('https');
}

Route::get('/admin/', function () {
    return redirect()->route('admin.login');
});

// Paypal Routes
Route::get('handle-payment', [PayPalPaymentController::class, 'handlePayment'])->name('make.payment');
Route::get('cancel-payment', [PayPalPaymentController::class, 'paymentCancel'])->name('cancel.payment');
Route::get('payment-success', [PayPalPaymentController::class, 'paymentSuccess'])->name('success.payment');

Route::post('pay-stripe', [MoneySetupController::class, 'stripe'])->name('stripe.pay');
Route::post('stripe', [MoneySetupController::class, 'stripePost'])->name('stripe.post');

Route::get('stripeform', [MoneySetupController::class, 'stripe'])->name('stripeform');
Route::get('stripeformsuccess/{id}', [MoneySetupController::class, 'stripeSuccess'])->name('stripeformsuccess');

Route::post('deliverytimeprice', [MoneySetupController::class, 'deliverytime_price'])->name('deliverytimeprice');
Route::post('productavailability', [MoneySetupController::class, 'checkProductAvailability'])->name('productavailability');

Route::get('errors', function () {
    return view('errors.500');
    exit();
})->name('errors');

Route::get('slugify', [HomeController::class, 'slugify'])->name('slugify');
