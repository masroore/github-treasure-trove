<?php

/*
 * This file is part of Hifone.
 *
 * (c) Hifone.com <hifone@hifone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hifone\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;

/**
 * This is the status page routes class.
 */
class ZenRoutes
{
    /**
     * Define the status page routes.
     */
    public function map(Registrar $router): void
    {
        $router->group(['middleware' => ['web', 'ready']], function (Registrar $router): void {
            //Pages
            $router->get('/{slug}', [
                'as' => 'page',
                'uses' => 'PageController@show',
            ]);
        });
    }
}
