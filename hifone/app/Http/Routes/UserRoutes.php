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
class UserRoutes
{
    /**
     * Define the status page routes.
     */
    public function map(Registrar $router): void
    {
        $router->group(['middleware' => ['web', 'ready', 'localize']], function (Registrar $router): void {
            $router->get('/user/{user}/replies', [
                'as' => 'user.replies',
                'uses' => 'UserController@replies',
            ]);

            $router->get('/user/{user}/threads', [
                'as' => 'user.threads',
                'uses' => 'UserController@threads',
            ]);

            $router->get('/user/{user}/favorites', [
                'as' => 'user.favorites',
                'uses' => 'UserController@favorites',
            ]);

            $router->get('/user/{user}/credits', [
                'as' => 'user.credits',
                'uses' => 'UserController@credits',
            ]);

            $router->get('/user/{user}/refresh_cache', [
                'as' => 'user.refresh_cache',
                'uses' => 'UserController@refreshCache',
            ]);

            $router->post('/user/{user}/unbind', [
                'as' => 'user.unbind_oauth',
                'uses' => 'UserController@unbind',
            ]);

            $router->get('/user/{user}/access_tokens', [
                'as' => 'user.access_tokens',
                'uses' => 'UserController@accessTokens',
            ]);

            $router->get('/access_token/{token}/revoke', [
                'as' => 'user.access_tokens.revoke',
                'uses' => 'UserController@revokeAccessToken',
            ]);

            $router->get('user/regenerate_login_token', [
                'as' => 'user.regenerate_login_token',
                'uses' => 'UserController@regenerateLoginToken',
            ]);

            //??????avatar
            $router->post('/settings/update-avatar', [
                'as' => 'user.avatarupdate',
                'uses' => 'UserController@avatarupdate',
            ]);
            //??????????????????
            $router->post('/settings/resetPassword', [
                'as' => 'user.resetPassword',
                'uses' => 'UserController@resetPassword',
            ]);

            $router->get('/u/{username}', [
                'as' => 'user.home',
                'uses' => 'UserController@showByUsername',
            ]);

            $router->get('/user/city/{name}', [
                'as' => 'user.city',
                'uses' => 'UserController@city',
            ]);

            $router->resource('user', 'UserController');
        });
    }
}
