<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Menu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $menu = null;
        if (Auth::check()) {
            $menu = $this->menuUsuario();
            if (Auth::user()->admin == 1) {
                $menu = $this->menuAdmin();
            }
        }
        View::share('menu', $menu);

        return $next($request);
    }

    /**
     * Permite Obtener el menu del usuario.
     */
    public function menuUsuario()
    {
        // $orden = app($OrdenService)->find($id);

        return [
            // Inicio
            'Dashboard' => [
                'submenu' => 0,
                'ruta' => route('home.user'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-home',
                'complementoruta' => '',
            ],
            // Fin inicio

            // Tienda
            'Tienda' => [
                'submenu' => 0,
                'ruta' => route('shop'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-shopping-cart',
                'complementoruta' => '',
            ],
            // Fin añadir Tienda

            // Negocio
            'Negocio' => [
                'submenu' => 1,
                'ruta' => 'javascripts:;',
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-briefcase',
                'complementoruta' => '',
                'submenus' => [
                    [
                        'name' => 'Árbol binario',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('genealogy_type', 'matriz'),
                        'complementoruta' => '',
                    ],
                    [
                        'name' => 'Directos',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('genealogy_list_network', 'direct'),
                        'complementoruta' => '',
                    ],
                    [
                        'name' => 'Inversiones',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('inversiones.index'),
                        'complementoruta' => '',
                    ],
                ],
            ],
            // Fin añadir Negocio
            //INVERSIONES
            'Inversiones' => [
                'submenu' => 0,
                'ruta' => route('inversiones.index'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-credit-card',
                'complementoruta' => '',
                // 'submenus' => [
                //     [
                //         'name' => 'Activas',
                //         'blank'=> '', // si es para una pagina diferente del sistema solo coloquen _blank
                //         'ruta' => route('inversiones.index', 1),
                //         'complementoruta' => ''
                //     ],
                //     [
                //         'name' => 'Culminadas',
                //         'blank'=> '', // si es para una pagina diferente del sistema solo coloquen _blank
                //         'ruta' => route('inversiones.index', 2),
                //         'complementoruta' => ''
                //     ]
                // ],
            ],
            // Financiero
            'Financiero' => [
                'submenu' => 1,
                'ruta' => 'javascripts:;',
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-dollar-sign',
                'complementoruta' => '',
                'submenus' => [
                    [
                        'name' => 'Wallet',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('wallet.index'),
                        'complementoruta' => '',
                    ],
                    // [
                    //     'name' => 'Generar Retiros',
                    //     'blank'=> '', // si es para una pagina diferente del sistema solo coloquen _blank
                    //     'ruta' => route('settlement'),
                    //     'complementoruta' => ''
                    // ],
                    [
                        'name' => 'Retiros',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('payments.index'),
                        'complementoruta' => '',
                    ],
                ],
            ],
            // Fin Financiero

            // Soporte
            'Soporte' => [
                'submenu' => 0,
                'ruta' => route('ticket.list-user'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-help-circle',
                'complementoruta' => '',
            ],
            // Fin Soporte
        ];
    }

    /**
     * Permite Obtener el menu del admin.
     */
    public function menuAdmin()
    {
        return [
            // Inicio
            'Dashboard' => [
                'submenu' => 0,
                'ruta' => route('home'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-home',
                'complementoruta' => '',
            ],
            // Fin inicio

            // Ordenes
            'Ordenes' => [
                'submenu' => 0,
                'ruta' => route('reports.pedidos'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-file-text',
                'complementoruta' => '',
            ],
            // Fin Ordenes

            // Paquetes
            'Paquetes' => [
                'submenu' => 0,
                'ruta' => route('products.package-list'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-archive',
                'complementoruta' => '',
            ],
            // Fin Paquetes

            // Red
            'Red' => [
                'submenu' => 1,
                'ruta' => 'javascripts:;',
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-globe',
                'complementoruta' => '',
                'submenus' => [
                    [
                        'name' => 'Usuarios',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('users.list-user'),
                        'complementoruta' => '',
                    ],
                    [
                        'name' => 'Árbol binario',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('genealogy_type', 'matriz'),
                        'complementoruta' => '',
                    ],
                    [
                        'name' => 'Directos',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('genealogy_list_network', 'direct'),
                        'complementoruta' => '',
                    ],
                ],
            ],
            // Fin Red

            // Inversiones
            'Inversiones' => [
                'submenu' => 0,
                'ruta' => route('inversiones.index'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-dollar-sign',
                'complementoruta' => '',
                // 'submenus' => [
                //     [
                //         'name' => 'Activas',
                //         'blank'=> '', // si es para una pagina diferente del sistema solo coloquen _blank
                //         'ruta' => route('inversiones.index', 1),
                //         'complementoruta' => ''
                //     ],
                //     [
                //         'name' => 'Culminadas',
                //         'blank'=> '', // si es para una pagina diferente del sistema solo coloquen _blank
                //         'ruta' => route('inversiones.index', 2),
                //         'complementoruta' => ''
                //     ]
                // ],
            ],
            // Fin Cierre Comisiones
            // Liquidaciones
            'Liquidaciones' => [
                'submenu' => 1,
                'ruta' => 'javascripts:;',
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-pocket',
                'complementoruta' => '',
                'submenus' => [
                    // [
                    //     'name' => 'Por generar',
                    //     'blank'=> '', // si es para una pagina diferente del sistema solo coloquen _blank
                    //     'ruta' => route('settlement'),
                    //     'complementoruta' => ''
                    // ],
                    // [
                    //     'name' => 'Pendientes',
                    //     'blank'=> '', // si es para una pagina diferente del sistema solo coloquen _blank
                    //     'ruta' => route('settlement.pending'),
                    //     'complementoruta' => ''
                    // ],
                    [
                        'name' => 'Realizadas',
                        'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                        'ruta' => route('settlement.history.status', 'Pagadas'),
                        'complementoruta' => '',
                    ],
                ],
            ],
            // Fin Retiros

            // Soporte
            'Soporte' => [
                'submenu' => 0,
                'ruta' => route('ticket.list-admin'),
                'blank' => '', // si es para una pagina diferente del sistema solo coloquen _blank
                'icon' => 'feather icon-help-circle',
                'complementoruta' => '',
            ],
            // Fin Soporte
        ];
    }
}
