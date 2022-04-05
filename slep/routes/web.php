<?php

use App\Models\Busqueda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
Route::group(['middleware' => ['get.menu']], function (): void {
    Route::get('/', function () {
        return view('auth.login');
    })->name('home');

    Route::get('/dashboard2', function () {
        return view('dashboard.homepage');
    })->name('homepage');

    Route::get('/external_su/', 'RegController@external_su');
    Route::get('/external_su_test/{name}&{email}&{password}&{empresa}', 'RegController@external_su_test');

    Route::get('/informe/{id}', 'InformeController@informeById');
    //Creacion publica de una campaña con 3 busquedas asociada a un usuario
    Route::get('/campaign_onboarding/{user_id}&{nombre_campania}&{word1}&{word2}&{word3}', 'Onboarding@mxIllcj4eviICPDss1oc');
    Route::get('/success_onboarding/', 'Onboarding@success');

    Route::get('/campañas/{id}/posts', 'CampaniaController@GetResultadosTwitter');
    Route::get('/campañas/{id}/videos', 'CampaniaController@GetResultadosYoutube');
    Route::get('/campañas/{id}/news', 'CampaniaController@GetResultadosGNews');
    Route::get('/campañas/{id}/facebookposts', 'CampaniaController@GetResultadosFacebook');
    Route::get('/campañas/{id}/instagramposts', 'CampaniaController@GetResultadosInstagram');
    Route::post('/words/', 'TwitterWSController@wordsHandle');

    Route::get('/rg/{name}&{email}&{password}&{empresa}', 'RegController@rg');
    Route::group(['middleware' => ['role:gestor']], function (): void {
        Route::get('/control_busquedas/', 'ControlPanel@busquedas');
        Route::get('/control_async/', 'ControlPanel@async');
        Route::get('/control_ws/', 'ControlPanel@ws');

        Route::get('/dt/', 'ControlPanel@dt');

        Route::get('/getBusquedasGestor', function (Request $request) {
            if ($request::ajax()) {
                $data = Busqueda::with('user')->with('campañas')->with('async')->with('googlenews')->get();

                return DataTables::of($data)
                     /*
                    ->addColumn('bd', function($row){
                        $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['bd'])

                        ->addIndexColumn()

                    */
                    ->make(true);
            }
        })->name('gestor.busquedas');

        Route::get('/get_userwroles_gst', function (Request $request) {
            if ($request::ajax()) {
                $data = User::with('roles')->get();

                return DataTables::of($data)->make(true);
            }
        });

        Route::get('/control_roles/', 'ControlPanel@roles');
        Route::put('/control_roles_edit/', 'ControlPanel@edit_roles_row');
        Route::delete('/control_roles_delete/', 'ControlPanel@delete_roles_row');
        Route::post('/control_roles_new/', 'ControlPanel@new');

        Route::get('/control_medios/', 'ControlPanel@medios');
        Route::post('/control_medios_edit/', 'ControlPanel@edit_medios_row');
        Route::delete('/control_medios_delete/', 'ControlPanel@delete_medios_row');
        Route::post('/control_medios_new/', 'ControlPanel@new_medio');
    });

    Route::get('/status/twitter', function () {
        try {
            $r = HTTP::get('localhost:3000/tweets/status');

            return json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure']);
        }
    });
    Route::get('/status/youtube', function () {
        try {
            $r = HTTP::get('localhost:3001/youtube/status');

            return json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure']);
        }
    });
    Route::get('/status/google_news', function () {
        try {
            $r = HTTP::get('localhost:3003/news/status');

            return json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure']);
        }
    });
    Route::get('/status/facebook', function () {
        try {
            $r = HTTP::get('localhost:3015/rfb/consulta/fb_prod_p3pSOHrU56');

            return json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure']);
        }
    });
    Route::get('/status/instagram', function () {
        try {
            $r = HTTP::get('localhost:3016/rig/consulta/fb_prod_p3pSOHrU56');

            return json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure']);
        }
    });
    Route::get('/status/google_ads', function () {
        try {
            $kw_ctrl = resolve('App\Http\Controllers\GenerateKeywordIdeas');
            $kw_rqst = new Request();
            $kw_rqst->words = 'status';
            $kw_ctrl->status($kw_rqst);

            return json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure']);
        }
    });

    Route::get('/api_status/twitter', function () {
        try {
            $r = HTTP::get('localhost:3000/tweets/status');

            return $r->json();
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure', 'error' => 'inactive ws']);
        }
    });
    Route::get('/api_status/youtube', function () {
        try {
            $r = HTTP::get('localhost:3001/youtube/status');

            return $r->json();
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure', 'error' => 'inactive ws']);
        }
    });
    Route::get('/api_status/google_news', function () {
        try {
            $r = HTTP::get('localhost:3003/news/status');

            return $r->json();
        } catch (\Exception $e) {
            return json_encode(['status' => 'failure', 'error' => 'inactive ws']);
        }
    });

    Route::group(['middleware' => ['role:user|guest|gestor']], function (): void {
        Route::get('/colors', function () {
            return view('dashboard.colors');
        });
        Route::get('/typography', function () {
            return view('dashboard.typography');
        });
        Route::get('/charts', function () {
            return view('dashboard.charts');
        });
        Route::get('/widgets', function () {
            return view('dashboard.widgets');
        });
        Route::get('/google-maps', function () {
            return view('dashboard.googlemaps');
        });
        Route::get('/404', function () {
            return view('dashboard.404');
        });
        Route::get('/500', function () {
            return view('dashboard.500');
        });
        Route::prefix('base')->group(function (): void {
            Route::get('/breadcrumb', function () {
                return view('dashboard.base.breadcrumb');
            });
            Route::get('/cards', function () {
                return view('dashboard.base.cards');
            });
            Route::get('/carousel', function () {
                return view('dashboard.base.carousel');
            });
            Route::get('/collapse', function () {
                return view('dashboard.base.collapse');
            });

            Route::get('/jumbotron', function () {
                return view('dashboard.base.jumbotron');
            });
            Route::get('/list-group', function () {
                return view('dashboard.base.list-group');
            });
            Route::get('/navs', function () {
                return view('dashboard.base.navs');
            });
            Route::get('/pagination', function () {
                return view('dashboard.base.pagination');
            });

            Route::get('/popovers', function () {
                return view('dashboard.base.popovers');
            });
            Route::get('/progress', function () {
                return view('dashboard.base.progress');
            });
            Route::get('/scrollspy', function () {
                return view('dashboard.base.scrollspy');
            });
            Route::get('/switches', function () {
                return view('dashboard.base.switches');
            });

            Route::get('/tabs', function () {
                return view('dashboard.base.tabs');
            });
            Route::get('/tooltips', function () {
                return view('dashboard.base.tooltips');
            });
        });
        Route::prefix('buttons')->group(function (): void {
            Route::get('/buttons', function () {
                return view('dashboard.buttons.buttons');
            });
            Route::get('/button-group', function () {
                return view('dashboard.buttons.button-group');
            });
            Route::get('/dropdowns', function () {
                return view('dashboard.buttons.dropdowns');
            });
            Route::get('/brand-buttons', function () {
                return view('dashboard.buttons.brand-buttons');
            });
            Route::get('/loading-buttons', function () {
                return view('dashboard.buttons.loading-buttons');
            });
        });
        Route::prefix('editors')->group(function (): void {
            Route::get('/code-editor', function () {
                return view('dashboard.editors.code-editor');
            });
            Route::get('/markdown-editor', function () {
                return view('dashboard.editors.markdown-editor');
            });
            Route::get('/text-editor', function () {
                return view('dashboard.editors.text-editor');
            });
        });

        Route::prefix('forms')->group(function (): void {
            Route::get('/basic-forms', function () {
                return view('dashboard.forms.basic-forms');
            });
            Route::get('/advanced-forms', function () {
                return view('dashboard.forms.advanced-forms');
            });
            Route::get('/validation', function () {
                return view('dashboard.forms.validation');
            });
        });

        Route::prefix('icon')->group(function (): void {  // word: "icons" - not working as part of adress
            Route::get('/coreui-icons', function () {
                return view('dashboard.icons.coreui-icons');
            });
            Route::get('/flags', function () {
                return view('dashboard.icons.flags');
            });
            Route::get('/brands', function () {
                return view('dashboard.icons.brands');
            });
        });
        Route::prefix('notifications')->group(function (): void {
            Route::get('/alerts', function () {
                return view('dashboard.notifications.alerts');
            });
            Route::get('/badge', function () {
                return view('dashboard.notifications.badge');
            });
            Route::get('/modals', function () {
                return view('dashboard.notifications.modals');
            });
            Route::get('/toastr', function () {
                return view('dashboard.notifications.toastr');
            });
        });
        Route::prefix('plugins')->group(function (): void {
            Route::get('/calendar', function () {
                return view('dashboard.plugins.calendar');
            });
            Route::get('/draggable-cards', function () {
                return view('dashboard.plugins.draggable-cards');
            });
            Route::get('/spinners', function () {
                return view('dashboard.plugins.spinners');
            });
        });
        Route::group(['middleware' => ['auth']], function (): void {
            Route::get('/', function () {
                return view('dashboard.slep.mantenedores');
            })->name('m');

            Route::get('/mantenedores', 'SlepCtrl@getMantenedores')->name('mantenedores');
            Route::get('/reportes', 'SlepCtrl@getReportes')->name('reportes');

            Route::prefix('tables')->group(function (): void {
                Route::get('/tables', function () {
                    return view('dashboard.tables.tables');
                });
                Route::get('/datatables', function () {
                    return view('dashboard.tables.datatables');
                });

                Route::get('/twittertables/{word}', 'TwitterWSController@losTweets');
                Route::get('/twittertables/', 'TwitterWSController@losTweetsNoSearch');

                Route::get('/buscador/', 'BuscadorController@index');
                Route::post('/buscador/', 'TwitterWSController@losTweets');

                Route::post('/words/', 'TwitterWSController@wordsHandle');

                Route::get('/consulta_resultados/', 'BuscadorController@ConsultaResultados');
                Route::get('/consulta_resultados/{id}/detalles', 'BuscadorController@ConsultaResultadosById');
                Route::get('/consulta_resultados/{id}/posts', 'BuscadorController@ConsultaPostsById');
                Route::get('/consulta_resultados/{id}/videos', 'BuscadorController@ConsultaVideosById');
                Route::get('/consulta_resultados/{id}/news', 'BuscadorController@ConsultaNewsById');
                Route::get('/consulta_resultados/{id}/facebookposts', 'BuscadorController@ConsultaFacebookPostsById');
                Route::get('/consulta_resultados/{id}/instagramposts', 'BuscadorController@ConsultaInstagramPostsById');
                ////
                Route::get('/consulta_resultados/{id}/all', 'BuscadorController@all');

                Route::get('/consulta_resultados/{id}/links', 'BuscadorController@ConsultaLinks');

                Route::get('/consulta_resultados_def', 'BuscadorController@ConsultaResultadosNoSearch');
                Route::get('/consulta_medios', 'BuscadorController@ConsultaMediosNoSearch');

                Route::post('/create_enterprise/', 'EmpresaController@crearEmpresa');
                Route::get('/get_enterprises/', 'EmpresaController@GetAll');
                Route::post('/select_enterprise/', 'EmpresaController@asociarEmpresa');

                Route::post('/campañas_def/', 'CampaniaController@crearNuevaCampaña');
                Route::get('/campañas_def/', 'CampaniaController@GetAll');
                Route::get('/campañas/getAll', 'CampaniaController@GetAllCampaniasRaw');
                Route::get('/campañas/{id}/', 'CampaniaController@GetBusquedas');
                Route::get('/campañas/{id}/posts', 'CampaniaController@GetResultadosTwitter');
                Route::get('/campañas/{id}/videos', 'CampaniaController@GetResultadosYoutube');
                Route::get('/campañas/{id}/news', 'CampaniaController@GetResultadosGNews');
                Route::get('/campañas/{id}/facebookposts', 'CampaniaController@GetResultadosFacebook');
                Route::get('/campañas/{id}/instagramposts', 'CampaniaController@GetResultadosInstagram');
                Route::get('/campañas/{id}/all', 'CampaniaController@GetAllResultados');

                Route::get('/menu_dashboard/{id}', 'MDashboardController@searchById');
                Route::get('/menu_dashboard_medios/{id}', 'MDashboardController@searchMediosById');
                Route::get('/campaña/{id}', 'CampaniaController@GetBusquedas');
                Route::get('/campañabyid/{id}', 'CampaniaController@GetCampañaById');
                Route::post('/campaña_add_busquedas/', 'CampaniaController@addBusquedas');
                Route::post('/campaña_delete_busquedas/', 'CampaniaController@deleteBusquedas');
                Route::post('/campaña_add_tags/', 'CampaniaController@addTags');
                Route::get('/busquedasbyid/{id}', 'CampaniaController@GetBusquedasRaw');

                Route::get('/campañas_de_busqueda/{id}', 'BuscadorController@getCampañasByBusqueda');
                Route::get('/resultado/{id}', 'BuscadorController@BusquedaById');

                Route::post('/delete_tw/', 'ResultadoController@DeleteById_TW');
                Route::post('/delete_yt/', 'ResultadoController@DeleteById_YT');
                Route::post('/delete_gn/', 'ResultadoController@DeleteById_GN');
                Route::post('/delete_fb/', 'ResultadoController@DeleteById_FB');
                Route::post('/delete_ig/', 'ResultadoController@DeleteById_IG');

                Route::post('/multiple_delete/', 'ResultadoController@deleteMultipleResults');

                Route::post('/tags_tw/', 'TagsController@setTags_TW');
                Route::post('/tags_yt/', 'TagsController@setTags_YT');
                Route::post('/tags_gn/', 'TagsController@setTags_GN');
                Route::post('/tags_fb/', 'TagsController@setTags_FB');
                Route::post('/tags_ig/', 'TagsController@setTags_IG');

                Route::post('/multiple_tags/', 'TagsController@setMultipleTags');
                //Route::get('/informe/{id}', 'InformeController@informeById');

                Route::get('/async_facebook_check_status/{code}', 'AsyncSourcesController@facebookCheckStatus');
                Route::get('/async_facebook_get_results/{code}', 'AsyncSourcesController@facebookGetResults');
                Route::get('/get_all_async_results/', 'AsyncSourcesController@getAllAsyncResults');

                Route::get('/async_instagram_check_status/{code}', 'AsyncSourcesController@instagramCheckStatus');
                Route::get('/async_instagram_get_results/{code}', 'AsyncSourcesController@instagramGetResults');

                Route::get('/export_all_database/', 'ExportController@index');
                Route::get('/export_campañas/', 'ExportController@databaseCampañas');
                Route::get('/export_busquedas/', 'ExportController@databaseBusquedas');

                Route::post('/to_reporte/', 'ExportController@toReportesTable');
                Route::get('/reporte_by_id/{id}', 'ExportController@ReporteById');
                Route::get('/reporte_all/', 'ExportController@ReporteAll');

                Route::get('/testing/', 'ExportController@testing');
                Route::get('/nube/', 'ExportController@wctest');

                Route::get('/registros/', 'BuscadorController@getStateTable');
                Route::get('/registros_data/', 'BuscadorController@getStateTableData');

                Route::get('/loginGraph/', 'BuscadorController@GraphLogin');
                Route::get('/getAccessToken', 'IGController@generateIGToken');
                Route::get('/get-photos', 'IGController@getMedia');
                Route::get('/ig-redirect-uri', 'IGController@igRedirectUri'); //this is the url earlier we added in app setup in facebook developer console

                Route::get('/md/{id}', 'MDashboardController@searchById_test');
            });
        });
        Route::prefix('apps')->group(function (): void {
            Route::prefix('invoicing')->group(function (): void {
                Route::get('/invoice', function () {
                    return view('dashboard.apps.invoicing.invoice');
                });
            });
            Route::prefix('email')->group(function (): void {
                Route::get('/inbox', function () {
                    return view('dashboard.apps.email.inbox');
                });
                Route::get('/message', function () {
                    return view('dashboard.apps.email.message');
                });
                Route::get('/compose', function () {
                    return view('dashboard.apps.email.compose');
                });
            });
        });
        Route::resource('notes', 'NotesController');
    });

    Auth::routes();

    Route::resource('resource/{table}/resource', 'ResourceController')->names([
        'index' => 'resource.index',
        'create' => 'resource.create',
        'store' => 'resource.store',
        'show' => 'resource.show',
        'edit' => 'resource.edit',
        'update' => 'resource.update',
        'destroy' => 'resource.destroy',
    ]);

    Route::group(['middleware' => ['role:admin']], function (): void {
        Route::resource('bread', 'BreadController');   //create BREAD (resource)

        Route::resource('users', 'UsersController')->except(['create', 'store']);
        Route::resource('languages', 'LanguageController');
        Route::resource('mail', 'MailController');
        Route::get('prepareSend/{id}', 'MailController@prepareSend')->name('prepareSend');
        Route::post('mailSend/{id}', 'MailController@send')->name('mailSend');
        Route::resource('roles', 'RolesController');
        Route::get('/roles/move/move-up', 'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down', 'RolesController@moveDown')->name('roles.down');
        Route::prefix('menu/element')->group(function (): void {
            Route::get('/', 'MenuElementController@index')->name('menu.index');
            Route::get('/move-up', 'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down', 'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create', 'MenuElementController@create')->name('menu.create');
            Route::post('/store', 'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents', 'MenuElementController@getParents');
            Route::get('/edit', 'MenuElementController@edit')->name('menu.edit');
            Route::post('/update', 'MenuElementController@update')->name('menu.update');
            Route::get('/show', 'MenuElementController@show')->name('menu.show');
            Route::get('/delete', 'MenuElementController@delete')->name('menu.delete');
        });
        Route::prefix('menu/menu')->group(function (): void {
            Route::get('/', 'MenuController@index')->name('menu.menu.index');
            Route::get('/create', 'MenuController@create')->name('menu.menu.create');
            Route::post('/store', 'MenuController@store')->name('menu.menu.store');
            Route::get('/edit', 'MenuController@edit')->name('menu.menu.edit');
            Route::post('/update', 'MenuController@update')->name('menu.menu.update');
            //Route::get('/show',     'MenuController@show')->name('menu.menu.show');
            Route::get('/delete', 'MenuController@delete')->name('menu.menu.delete');
        });
        Route::prefix('media')->group(function (): void {
            Route::get('/', 'MediaController@index')->name('media.folder.index');
            Route::get('/folder/store', 'MediaController@folderAdd')->name('media.folder.add');
            Route::post('/folder/update', 'MediaController@folderUpdate')->name('media.folder.update');
            Route::get('/folder', 'MediaController@folder')->name('media.folder');
            Route::post('/folder/move', 'MediaController@folderMove')->name('media.folder.move');
            Route::post('/folder/delete', 'MediaController@folderDelete')->name('media.folder.delete');

            Route::post('/file/store', 'MediaController@fileAdd')->name('media.file.add');
            Route::get('/file', 'MediaController@file');
            Route::post('/file/delete', 'MediaController@fileDelete')->name('media.file.delete');
            Route::post('/file/update', 'MediaController@fileUpdate')->name('media.file.update');
            Route::post('/file/move', 'MediaController@fileMove')->name('media.file.move');
            Route::post('/file/cropp', 'MediaController@cropp');
            Route::get('/file/copy', 'MediaController@fileCopy')->name('media.file.copy');
        });
    });
});

Route::get('locale', 'LocaleController@locale');

//Redirigir al usuario hacia Facebook (donde el usuario aceptará continuar, proporcionando sus datos básicos)
Route::get('login/{driver}', 'Auth\LoginController@redirect');
//Gestionar la respuesta de Facebook (si acepta, le creamos una cuenta en nuestra app, o bien le permitimos ingresar con su usuario ya existente)
Route::get('login/{driver}/callback', 'Auth\LoginController@callback');

//Public Keyword Ideas Request
Route::get('/LaZ6GBiK48sJ4qdNGXXk/{c1}&{c2}&{c3}&{nombreUsuario}&{email}&{empresa}&{telefono}&{nombre_campania}', 'GenerateKeywordIdeas@SZTg2FkeozJAJPebUOCW');
