<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth;
use App\Http\Controllers\ClickController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ToolController;
use App\Models\Banner;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::post('/upload', [ToolController::class, 'upload'])->name('upload');

Route::get('/', [MainController::class, 'index']);

Route::get('/test2/{post}', [PostController::class, 'list_test']);
Route::get('/test', [TestController::class, 'index']);

Auth::routes();
Route::get('/logout', [Auth\LoginController::class, 'logout']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update']);
});

/// Admin Start
Route::prefix('admin')->middleware('auth', 'isAdmin')->group(function (): void {
    Route::get('/', [Admin\AdminController::class, 'index']);
    Route::resource('/roles', Admin\RolesController::class);
    Route::resource('/permissions', Admin\PermissionsController::class);
    Route::resource('/users', Admin\UsersController::class);

    Route::resource('/pages', Admin\PagesController::class);
    Route::resource('/activitylogs', Admin\ActivityLogsController::class)->only([
        'index', 'show', 'destroy',
    ]);
    Route::resource('/settings', Admin\SettingsController::class);
    Route::resource('/banners', Admin\BannersController::class);
    Route::resource('/posts', Admin\PostsController::class);

    Route::resource('/tags', Admin\TagsController::class);

    Route::post('/banners/{id}/status', [Admin\BannersController::class, 'status'])->name('banners.status');
    Route::resource('/statics', Admin\StaticsController::class);

    // Route::resource('admin/tasks', 'Admin\\TasksController');
    Route::GET('/tools/status', [Admin\ToolsController::class, 'status']);
});

Route::prefix('admin')->middleware()->group(function (): void {
    // Route::get('generator', ['uses' => [\Appzcoder\LaravelAdmin\Controllers\ProcessController::class, 'getGenerator']]);
    // Route::post('generator', ['uses' => [\Appzcoder\LaravelAdmin\Controllers\ProcessController::class, 'postGenerator']]);
});

// Route::group(['middleware'=>['auth', 'isAdmin' ] ,  ] , function(){
// Route::group(['middleware' => [], 'prefix'='admin'], function () {
// });
/// Admin END

/// User WWW Start

Route::resource('posts', PostController::class)->only([
    'index',  'store', 'show', 'create', 'update', 'destroy',
]);

// Route::resource('customers', 'CustomerController')->only([
//     'index',  'store', 'show', 'create', 'update', 'destroy'
// ]);

Route::resource('customers', CustController::class)->only([
    'index',  'store', 'show', 'create', 'update', 'destroy',
]);

Route::get('inputPassword', [CustController::class, 'inputPassword'])->name('inputPassword');

Route::get('tags/{tag}', [TagController::class, 'index']);

Route::get('click', [ClickController::class, 'redirect']);
Route::get('navigate', [ClickController::class, 'navigate']);

Route::resource('/upsos', UpsoController::class);
Route::resource('/managers', ManagerController::class);
Route::get('/managers-list', [ManagerController::class, 'list'])->name('managers.list');

Route::get('/managers-test/{manager}', [ManagerController::class, 'test']);

Route::post('/comments/save', [CommentController::class, 'store'])->name('comments.store');

/// User WWW END

View::composer('*', function ($view): void {
    $user_menus = [
        ['key' => 'upsos', 'title' => '????????????', 'type' => 'upso', 'link' => '/upsos', 'src' => '/img/kr-111.jpg'],
        ['key' => 'managers', 'title' => '???????????????', 'type' => 'manager', 'link' => '/managers', 'src' => '/img/kr-111.jpg'],

        ['key' => 'kr', 'title' => '????????????', 'type' => 'gallery', 'link' => '/posts?cat_id=1', 'src' => '/img/kr-111.jpg'],
        ['key' => 'jp', 'title' => '????????????', 'type' => 'gallery', 'link' => '/posts?cat_id=2', 'src' => '/img/jp-111.jpg'],
        ['key' => 'asia', 'title' => '????????????', 'type' => 'gallery', 'link' => '/posts?cat_id=3', 'src' => '/img/dy-111.jpg'],
        ['key' => 'western', 'title' => '????????????', 'type' => 'gallery', 'link' => '/posts?cat_id=4', 'src' => '/img/xy-111.jpg'],

        ['key' => 'torrent', 'title' => 'av?????????', 'type' => 'torrent', 'link' => 'https://yaburi01.com/posts-index/19', 'src' => '/img/avtorrent.jpg'],

        ['key' => 'bbs', 'title' => '????????????', 'type' => 'dropdown', 'link' => '/customers?ccat_id=1', 'src' => ''],

        ['key' => 'upso', 'title' => '????????????', 'type' => 'outlink', 'link' => '/', 'src' => '/img/upso.jpg'],
        ['key' => 'broadcast', 'title' => '???????????????', 'type' => 'outlink', 'link' => 'http://betmoa00.com', 'src' => '/img/betmoa.jpg'],
        ['key' => 'bet', 'title' => '?????????', 'type' => 'outlink', 'link' => '/', 'src' => '/img/lets_play.jpg'],
        ['key' => 'quest', 'title' => '1:1??????', 'type' => 'list-password', 'link' => '/customers?ccat_id=1', 'src' => ''],
        ['key' => 'banner', 'title' => '????????????', 'type' => 'list-password', 'link' => '/customers?ccat_id=2', 'src' => ''],
    ];

    // $user_menus = json_decode(json_encode($user_menus), FALSE);
    // dd($user_menus);

    $banners = [];
    foreach (range(1, 12) as $x) {
        $banners[] = ['file_name' => '/storage/upload/banners/1.gif', 'link' => 'https://daum.net'];
    }
    $banners = json_decode(json_encode($banners), false);
    $fb = 'banners.json';
    if (!Storage::exists($fb)) {
        Banner::saveBanner();
    }

    $object = (array) json_decode(Storage::get($fb));
    $collection = Banner::hydrate($object);
    $banners = $collection->flatten();   // get rid of unique_id_XXX

    $view->with('user_menus', $user_menus)->with('banners', $banners);
});
