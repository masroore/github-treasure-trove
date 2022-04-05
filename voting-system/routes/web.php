<?php

use App\Http\Controllers\VoteController;
use App\Models\Artists;
use App\Models\Groups;
use App\Models\Seasons;
use App\Models\Stages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/dashboard', function () {
    $season = Seasons::where('status', 0)->first();
    $stage = Stages::where('status', 0)->first();
    $groups = Groups::with('nominees')->where('stage_id', $stage->id)->get();
    $seasons = Seasons::all();
    $stages = Stages::get();

    return view('dashboard', [
        'season' => $season,
        'stage' => $stage,
        'groups' => $groups,
        'seasons' => $seasons,
        'stages' => $stages,
    ]);
})->name('dashboard');

Route::get('/charts/{stage}', function ($stage) {
    $season = Seasons::where('status', 0)->first();
    $stage = Stages::where('url_hash', $stage)->first();
    $groups = Groups::where('stage_id', $stage->id)->get();
    $seasons = Seasons::all();
    $stages = Stages::get();

    return view('dashboard', [
        'season' => $season,
        'stage' => $stage,
        'groups' => $groups,
        'seasons' => $seasons,
        'stages' => $stages,
    ]);
})->name('chart');

Route::get('/', function () {
    $season = Seasons::where('status', 0)->first();
    $stage = Stages::where('status', 0)->first();

    return view('welcome', [
        'season' => $season,
        'stage' => $stage,
    ]);
})->name('welcome');

Route::get('/group/{group}', function ($group) {
    $season = Seasons::where('status', 0)->first();
    $stage = Stages::where('status', 0)->first();
    $group = Groups::where('url_hash', $group)->first();

    return view('group', [
        'season' => $season,
        'stage' => $stage,
        'group' => $group,
    ]);
})->name('group');

Route::get('/groups', function () {
    $season = Seasons::where('status', 0)->first();
    $stage = Stages::where('status', 0)->first();

    return view('groups', [
        'season' => $season,
        'stage' => $stage,
    ]);
})->name('group');

Route::get('/profile', function () {
    $season = Seasons::where('status', 0)->first();
    $stage = Stages::where('status', 0)->first();

    return view('profile', [
        'season' => $season,
        'stage' => $stage,
    ]);
})->name('profile');

Route::get('/artist/{artist}/{group}', function ($artist, $group) {
    $season = Seasons::where('status', 0)->first();
    $stage = Stages::where('status', 0)->first();
    $findArtist = Artists::where('url_hash', $artist)->first();

    return view('artist', [
        'season' => $season,
        'stage' => $stage,
        'group' => $group,
        'artist' => $findArtist,
    ]);
})->name('detail');

Route::get('vote', [VoteController::class, 'vote']);
Route::get('auth/google', [VoteController::class, 'redirectToGoogle'])->name('redirect');
Route::get('auth/google/callback', [VoteController::class, 'handleGoogleCallback']);

Route::get('/test', function () {
    $items = DB::table('artists')->get();

    foreach ($items as $value) {
        DB::table('artists')->where('id', $value->id)->update([
            'url_hash' => bin2hex(Str::random(40)),
        ]);
    }

    return true;
})->name('detail');

require __DIR__ . '/auth.php';
