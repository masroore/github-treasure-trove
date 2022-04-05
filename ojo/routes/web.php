<?php

use App\Http\Controllers\AuthController;

//LIVEWIRE COMPONENTS

use App\Http\Livewire\Casos;
use App\Http\Livewire\Correos;
use App\Http\Livewire\DataCorreo;
use App\Http\Livewire\DataCuentaBancaria;
use App\Http\Livewire\DataImagen;
use App\Http\Livewire\DataPaginaWeb;
use App\Http\Livewire\DataRedSocial;
use App\Http\Livewire\DataTarjeta;
use App\Http\Livewire\DataTelefono;
use App\Http\Livewire\Home;

use App\Http\Livewire\Personas;
use App\Http\Livewire\Reniec;

use App\Http\Livewire\TelefonosClaro;
use App\Http\Livewire\TelefonosEntel;
use App\Http\Livewire\TelefonosMovistar;
use App\Http\Livewire\UserActivity;
use App\Http\Livewire\Users;
use App\Http\Livewire\UsersPermissions;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [AuthController::class, 'index'])->name('init');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/validacion', [AuthController::class, 'validacion'])->name('validacion');

Route::get('/form_validacion', [AuthController::class, 'form_validacion'])->name('form_validacion');

Route::group(['middleware' => ['auth', 'auth2fa'], 'prefix' => 'dashboard'], function (): void {
    Route::group(['middleware' => ['can:Sistema']], function (): void {

      //CASOS
        Route::get('/casos', Casos::class)->name('casos');

        Route::get('/personas', Personas::class)->name('personas');

        // ELEMENTOS BUSQUEDA

        Route::get('/telefonos', DataTelefono::class)->name('telefonos');
        Route::get('/correos', DataCorreo::class)->name('correos');
        Route::get('/cuentas-bancarias', DataCuentaBancaria::class)->name('cuentas-bancarias');
        Route::get('/paginas-web', DataPaginaWeb::class)->name('paginas-web');
        Route::get('/redes-sociales', DataRedSocial::class)->name('redes-sociales');
        Route::get('/tarjetas', DataTarjeta::class)->name('tarjetas');
        Route::get('/imagenes', DataImagen::class)->name('imagenes');

        //sistema

        Route::get('/', Home::class)->name('home');

        Route::get('/users', Users::class)->name('users');

        Route::get('/permisos', UsersPermissions::class)->name('permisos');

        Route::get('/user-activity', UserActivity::class)->name('user_activity');
    });

    Route::group(['middleware' => ['can:Claro']], function (): void {
        Route::get('/claro', TelefonosClaro::class)->name('claro');
    });

    Route::group(['middleware' => ['can:Movistar']], function (): void {
        Route::get('/movistar', TelefonosMovistar::class)->name('movistar');
    });

    Route::group(['middleware' => ['can:Entel']], function (): void {
        Route::get('/entel', TelefonosEntel::class)->name('entel');
    });

    Route::group(['middleware' => ['can:Reniec']], function (): void {
        Route::get('/reniec', Reniec::class)->name('reniec');
    });

    Route::group(['middleware' => ['can:Email']], function (): void {
        Route::get('/email', Correos::class)->name('email');
    });
});
