<?php

namespace App\Http\Controllers\Api\Auth\Traits;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

trait RegistersUsers
{
    /**
     * @api {post} /api/v1/auth/register 1. Регистрация
     * @apiVersion 1.0.0
     * @apiName AuthRegister
     * @apiGroup 02.Авторизация
     *
     * @apiDescription Регистрация пользователя на сайте
     *
     * @apiParam {String} name Имя пользователя
     * @apiParam {String} login Email/Phone пользователя
     * @apiParam {String} password Пароль пользователя
     * @apiParam {String} role Роль пользователя <br> Допустимые значения: <code>user, partner</code>
     *
     * @apiSuccessExample {json} Успешный вход:
     *     HTTP/1.1 200 OK
     *     {
     *       "access_token": "eyJ0eXAiOiJK...",
     *       "token_type": "bearer"
     *       "expires_in": "3600"
     *     }
     *
     * @apiSuccessExample {json} Нужно подтверждение email:
     *     HTTP/1.1 403
     *     {
     *       "message": "Check your email to activate email.",
     *       "verify": false
     *     }
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if ($user->email) {
            $user->sendEmailVerificationNotification();

            return response()->json([
                'message' => trans('system.email.check'),
                'verify' => false,
            ], Response::HTTP_FORBIDDEN);
        }

        $token = $user->createToken($request->login);
//        $token = $this->guard()->login($user);

        return response()->json([
            'message' => trans('auth.register.success'),
            'token' => $token->plainTextToken,
            //            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ], Response::HTTP_OK);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
