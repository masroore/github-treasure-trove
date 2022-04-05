<?php

use Illuminate\Support\Facades\Artisan;
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
Route::get('/clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    // Mail::send('correo.subcripcion', ['data' => []], function ($correo2)
    //     {
    //         $correo2->subject('Limpio el sistema');
    //         $correo2->to('cgonzalez.byob@gmail.com');
    //     });
    return 'DONE'; //Return anything
});
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');

    return 'DONE'; //Return anything
});
Route::get('/storage-link', function () {
    $exitCode = Artisan::call('storage:link');

    return 'DONE'; //Return anything
});

Route::post('/user/login', 'UserController@login')->name('users.login');

Auth::routes();

Route::prefix('')->middleware('menu', 'auth')->group(function (): void {
    Route::get('/', 'InicioController@home')->name('inicio.index')->withoutMiddleware(['menu', 'auth']);
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
        Route::get('/groups/{idgroup}/products', 'TiendaController@products')->name('shop.products');
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
        Route::get('kyc', 'UserController@kyc')->name('kyc');

        Route::get('profile', 'UserController@editProfile')->name('profile');

        Route::get('user-list', 'UserController@listUser')->name('users.list-user')->middleware('auth', 'checkrole:1');
        Route::get('user-edit/{id}', 'UserController@editUser')->name('users.edit-user');
        Route::get('user-show/{id}', 'UserController@showUser')->name('users.show-user');
        Route::patch('user-verify/{id}', 'UserController@verifyUser')->name('users.verify-user');
        Route::patch('user-update/{id}', 'UserController@updateUser')->name('users.update-user');
        Route::delete('user/delete/{id}', 'UserController@destroyUser')->name('users.destroy-user');

        Route::patch('profile-update', 'UserController@updateProfile')->name('profile.update');
        Route::patch('profile-update-kyc', 'UserController@updateProfileKYC')->name('profile.update.kyc');

        Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
        Route::get('change-password', 'ChangePasswordController@change-password')->name('profile.change-password');

        Route::get('/impersonate/stop', 'ImpersonateController@stop')->name('impersonate.stop');
        Route::post('/impersonate/{user}/start', 'ImpersonateController@start')->name('impersonate.start');

        Route::post('liquidation/retirarSaldo', 'LiquidactionController@retirarSaldo')->name('retirarSaldo');
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
            Route::get('package-categoria-create', 'GroupsController@index')->name('products.categories-create');
        });

        //Ruta de liquidacion
        Route::prefix('settlement')->group(function (): void {
            //Ruta liquidaciones realizadas
            Route::get('/', 'LiquidactionController@index')->name('settlement');
            Route::get('/pending', 'LiquidactionController@indexPendientes')->name('settlement.pending');
            Route::post('/process', 'LiquidactionController@procesarLiquidacion')->name('settlement.process');
            Route::get('/{status}/history', 'LiquidactionController@indexHistory')->name('settlement.history.status');
            Route::resource('liquidation', 'LiquidactionController');
        });

        //Rutas para el cierre de productos
        Route::prefix('accounting')->group(function (): void {
            Route::resource('commission_closing', 'CierreComisionController');
        });
        //Rutas para los reportes
        Route::prefix('reports')->group(function (): void {
            Route::post('/detailOrden', 'ReporteController@detailOrden')->name('orden.detail');
            Route::get('commission', 'ReporteController@indexComision')->name('reports.comision');
        });

        Route::get('pagarUtilidad', 'WalletController@pagarUtilidad')->name('pagarUtilidad');

        Route::put('updatePorcentajeGanancia', 'InversionController@updatePorcentajeGanancia')->name('updatePorcentajeGanancia');
    });
    //Rutas para los reportes
    Route::prefix('reports')->group(function (): void {
        Route::get('purchase', 'ReporteController@indexPedidos')->name('reports.pedidos');
    });
    Route::get('dataGrafica', 'HomeController@dataGrafica')->name('dataGrafica');

    Route::get('testRank', 'RankController@testRank')->name('testRank');

    Route::prefix('')->group(function (): void {

    //Route::get('/inicio', 'HomeController@home')->name('inicio');

        Route::get('/about', 'HomeController@about')->name('about')->withoutMiddleware(['menu', 'auth']);

        Route::get('/contact_us', 'HomeController@contact_us')->name('contact_us')->withoutMiddleware(['menu', 'auth']);

        Route::post('/contactar', 'HomeController@contact')->name('contact')->withoutMiddleware(['menu', 'auth']);

        Route::get('/faq', 'HomeController@faq')->name('faq')->withoutMiddleware('menu', ['auth']);

        Route::get('/shop', 'TiendaController@shop')->name('shop.backofice')->withoutMiddleware(['menu', 'auth']);

        Route::get('/cart', 'TiendaController@cart')->name('cart')->withoutMiddleware(['menu', 'auth']);

        Route::post('/cart-GUEST', 'TiendaController@cart')->name('cart.GUEST')->withoutMiddleware(['menu', 'auth']);

        Route::post('/cart-post', 'TiendaController@cart_save')->name('cart.post')->withoutMiddleware(['menu', 'auth']);

        Route::patch('cart-update/{id}', 'TiendaController@updateCart')->name('cart.update');

        Route::get('/checkout', 'TiendaController@checkout')->name('checkout.backofice')->withoutMiddleware(['menu', 'auth']);

        Route::get('/product-detail/{producto}', 'TiendaController@detalleproducto')->name('detalle.producto')->withoutMiddleware(['menu', 'auth']);

        Route::get('terms', 'HomeController@terms')->name('terms')->withoutMiddleware(['menu', 'auth']);

        Route::get('policity', 'HomeController@policity')->name('policity')->withoutMiddleware(['menu', 'auth']);

        Route::get('/categoria/{Categories}', 'CategoriasController@show')->name('categorias.show')->withoutMiddleware(['menu', 'auth']);

        Route::get('orden', 'TiendaController@orden')->name('orden');

        Route::delete('cart-delete/{producto}', 'TiendaController@destroy')->name('destroy');

        Route::delete('cart-deleteGUES/{producto}', 'TiendaController@destroyGUES')->name('destroyGUES')->withoutMiddleware(['menu', 'auth']);

        Route::get('/MisCompras', 'TiendaController@misCompras')->name('MisCompras');
    });
});

Route::get('test', function () {
    // Cart::add('222', 'Product 123', 1, 9.99);

    foreach (Cart::instance('shopping')->content()->sortByDesc('id') as $item) {
        dd($item->model->name);
    }

    return Cart::content();
});
