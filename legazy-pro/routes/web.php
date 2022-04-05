<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*+
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {return view('welcome');})->middleware('auth');

Auth::routes();

Route::get('checkEmail/{id}', 'UserController@checkEmail')->name('checkemail');

Route::get('/', 'HomeController@home')->middleware('auth');

Route::prefix('dashboard')->middleware('menu', 'auth', 'check.email')->group(function (): void {
    // 2fact
    Route::get('/2fact', 'DoubleAutenticationController@index')->name('2fact');
    Route::post('/2fact', 'DoubleAutenticationController@checkCodeLogin')->name('2fact.post');
    // Inicio
    Route::get('/home', 'HomeController@index')->name('home');
    // Inicio de usuarios
    Route::get('/home-user', 'HomeController@indexUser')->name('home.user');
    // Ruta para obtener la informacion de la graficas del dashboard
    Route::get('getdatagraphicdashboard', 'HomeController@getDataGraphic')->name('home.data.graphic');

    // Red de usuario
    Route::prefix('genealogy')->group(function (): void {
        // Ruta para ver la lista de usuarios
        Route::get('users/{network}', 'TreeController@indexNewtwork')->name('genealogy_list_network');
        // Ruta para visualizar el arbol o la matriz
        Route::get('{type}', 'TreeController@index')->name('genealogy_type');
        // Ruta para visualizar el arbol o la matriz de un usuario en especifico
        Route::get('{type}/{id}', 'TreeController@moretree')->name('genealogy_type_id');
    });

    // Ruta para la billetera
    Route::prefix('wallet')->group(function (): void {
        Route::get('/', 'WalletController@index')->name('wallet.index');
    });

    // Ruta para la pagos
    Route::prefix('payments')->group(function (): void {
        Route::get('/', 'WalletController@payments')->name('payments.index');
    });

    Route::prefix('inversiones')->group(function (): void {
        Route::get('/lists', 'InversionController@index')->name('inversiones.index');
        // Route::get('/{tipo?}/lists', 'InversionController@index')->name('inversiones.index');
        Route::get('/cambiarStatus', 'InversionController@checkStatus')->name('inversiones.checkStatus');
    });

    // Ruta para la tienda
    Route::prefix('shop')->group(function (): void {
        Route::get('/', 'TiendaController@index')->name('shop');
        // Route::get('/groups/{idgroup}/products', 'TiendaController@products')->name('shop.products');
        Route::post('/procces', 'TiendaController@procesarOrden')->name('shop.procces');
        Route::post('/ipn', 'TiendaController@ipn')->name('shop.ipn');
        Route::get('/{status}/estado', 'TiendaController@statusProcess')->name('shop.proceso.status');
        Route::post('cambiarStatus', 'TiendaController@cambiar_status')->name('cambiarStatus');
    });

    // Ruta para las funciones por alla que no correspondan a otra seccion
    Route::prefix('ajax')->group(function (): void {
        Route::get('/update/{side}/binary', 'HomeController@updateSideBinary')->name('ajax.update.side.binary');
    });

    //Ruta para los usuarios
    Route::prefix('user')->group(function (): void {

        // Route::get('kyc', 'UserController@kyc')->name('kyc');

        Route::get('profile', 'UserController@editProfile')->name('profile');

        Route::get('user-list', 'UserController@listUser')->name('users.list-user')->middleware('auth', 'checkrole:1');
        // Route::get('user-edit/{id}', 'UserController@editUser')->name('users.edit-user');
        // Route::get('user-show/{id}', 'UserController@showUser')->name('users.show-user');
        // Route::patch('user-verify/{id}', 'UserController@verifyUser')->name('users.verify-user');
        // Route::patch('user-update/{id}', 'UserController@updateUser')->name('users.update-user');
        // Route::delete('user/delete/{id}','UserController@destroyUser')->name('users.destroy-user');
        // permite hacer operaciones con el authenticador de google
        Route::get('{tipo}/{id}/action', 'UserController@processAuthentication')->name('user.authentication');

        Route::patch('profile-update', 'UserController@updateProfile')->name('profile.update');
        // Route::patch('profile-update-kyc', 'UserController@updateProfileKYC')->name('profile.update.kyc');

        Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
        Route::get('change-password', 'ChangePasswordController@change-password')->name('profile.change-password');

        Route::get('/impersonate/stop', 'ImpersonateController@stop')->name('impersonate.stop');
        Route::post('/impersonate/{user}/start', 'ImpersonateController@start')->name('impersonate.start');

        Route::get('sendcode', 'UserController@sendCodeEmail')->name('user.send.code');
    });

    //Ruta de los Tickets
    Route::prefix('tickets')->group(function (): void {
        Route::get('ticket-create', 'TicketsController@create')->name('ticket.create');
        Route::post('ticket-store', 'TicketsController@store')->name('ticket.store');

        // Para el usuario
        Route::get('ticket-edit-user/{id}', 'TicketsController@editUser')->name('ticket.edit-user');
        Route::patch('ticket-update-user/{id}', 'TicketsController@updateUser')->name('ticket.update-user');
        Route::get('ticket-list-user', 'TicketsController@listUser')->name('ticket.list-user');
        Route::get('ticket-show-user/{id}', 'TicketsController@showUser')->name('ticket.show-user');

        // Para el Admin
        Route::get('ticket-edit-admin/{id}', 'TicketsController@editAdmin')->name('ticket.edit-admin');
        Route::patch('ticket-update-admin/{id}', 'TicketsController@updateAdmin')->name('ticket.update-admin');
        Route::get('ticket-list-admin', 'TicketsController@listAdmin')->name('ticket.list-admin');
        Route::get('ticket-show-admin/{id}', 'TicketsController@showAdmin')->name('ticket.show-admin');
    });

    //Ruta de liquidacion
    Route::prefix('settlement')->group(function (): void {
        //Ruta liquidaciones realizadas
        Route::get('/', 'LiquidactionController@index')->middleware('checkrole')->name('settlement');
        Route::get('/pending', 'LiquidactionController@indexPendientes')->middleware('checkrole')->name('settlement.pending');
        Route::post('/process', 'LiquidactionController@procesarLiquidacion')->name('settlement.process');
        Route::get('/{status}/history', 'LiquidactionController@indexHistory')->middleware('checkrole')->name('settlement.history.status');
        Route::resource('liquidation', 'LiquidactionController')->middleware('checkrole');

        Route::get('/withdraw', 'LiquidactionController@withdraw')->name('settlement.withdraw');
        Route::get('{wallet}/sendcodeemail', 'LiquidactionController@sendCodeEmail')->name('send-code-email');
    });

    /**
     * Seccion del sistema para el admin.
     */
    Route::prefix('admin')->middleware('checkrole')->group(function (): void {

        //Agregar servicios
        Route::prefix('products')->group(function (): void {
            //Rutas para los grupos
            Route::resource('group', 'GroupsController');

            //Rutas para los paquetes
            Route::resource('package', 'PackagesController');
            Route::get('package-list', 'PackagesController@package')->name('products.package-list');
            Route::get('package-update', 'PackagesController@update')->name('products.package-update');
            Route::get('package-grupos', 'GroupsController@index')->name('products.package-grupos');
            Route::get('package-index', 'PackagesController@index')->name('products.package-index');
            Route::get('package-create', 'PackagesController@create')->name('products.package-create');
        });

        //Rutas para el cierre de productos
        Route::prefix('accounting')->group(function (): void {
            Route::resource('commission_closing', 'CierreComisionController');
        });

        //Rutas para los reportes
        Route::prefix('reports')->group(function (): void {
            Route::get('purchase', 'ReporteController@indexPedidos')->name('reports.pedidos');
            Route::get('commission', 'ReporteController@indexComision')->name('reports.comision');
        });

        Route::get('pagarUtilidad', 'WalletController@pagarUtilidad')->name('pagarUtilidad');

        Route::put('updatePorcentajeGanancia', 'InversionController@updatePorcentajeGanancia')->name('updatePorcentajeGanancia');
    });

    Route::get('dataGrafica', 'HomeController@dataGrafica')->name('dataGrafica');
});
