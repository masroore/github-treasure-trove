<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UploadImageController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Livewire\Messages\ContactMe;
use App\Http\Livewire\Messages\DisplayMessages;
use App\Http\Livewire\User\Profile;

Route::redirect('/', 'root');
Route::mediaLibrary();
/**
 * App Routes.
 */
Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/message', DisplayMessages::class)->name('messages');
});

Route::get('/uploadtest', function () {
    return view('livewire.images.upload');
});

// Home Routes web security
Route::group(['middleware' => 'web'], function (): void {
    Route::get('/contactme', ContactMe::class);

    Route::get('/', [ProductController::class, 'index'])->name('root');

    Route::get('/theartist', function () {
        return view('homepages.theartist');
    });
    Route::get('/whyborneo', function () {
        return view('homepages.whyborneo');
    });
    Route::get('/materials', function () {
        return view('homepages.materials');
    });
    Route::get('/coming_soon', function () {
        return view('homepages.comingsoon');
    });
    Route::get('/loadimages', function () {
        return view('images.load');
    });
});

Route::get('/status/{status}', [ProductController::class, 'status'])->name('productStatus');

Route::get('/bycategory/{id}', [CategoryController::class, 'bycategory'])->name('bycategory');

Route::resource('product', ProductController::class);
Route::resource('category', CategoryController::class);

Auth::routes();

Route::name('images.')->group(function (): void {
    Route::get('/images', [UploadImageController::class, 'index'])->name('index');
    Route::get('/images/{product}/load', [UploadImageController::class, 'load'])->name('load');
    Route::get('/images/{product}/{image}/delete', [UploadImageController::class, 'delete'])->name('delete');
    Route::get('/images/{product}/{image}/featured', [UploadImageController::class, 'featured'])->name('makefeatured');
    Route::get('/images/{image}', [UploadImageController::class, 'show'])->name('show');
    Route::post('/images/upload', [UploadImageController::class, 'upload'])->name('upload');
});

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/profile/{id}', [UserController::class, 'show'])->name('user.profile');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('user.update');
});
