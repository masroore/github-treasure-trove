<?php

namespace App\Http\Controllers\Api\Auth\Traits;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

trait AuthenticatesUsers
{
    use CheckLoginType;

    protected $loginVia = 'email';

    /**
     * @api {post} /api/v1/auth/login 2. Токен авторизации
     * @apiVersion 1.0.0
     * @apiName AuthLogin
     * @apiGroup 02.Авторизация
     *
     * @apiDescription Получение токена api-доступа для авторизации пользователя.
     * <br>Для авторизации используется технология OAuth 2.0
     * <br>Для получения ресурсов авторизированного пользователя,
     * <br>к каждому запросу нужно в header прикрепить полученный токен (access_token):
     * <br><code>Authorization: Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} login Email/Phone пользователя
     * @apiParam {String} password Пароль пользователя
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
     *       "message": "Your email address is not verified.",
     *       "verify": false
     *     }
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $user = User::where($this->conditions($request))->first();

//        dd($user);
        if (!$token = $user->createToken($request->login)) {
            return response()->json(['message' => trans('auth.failed')], Response::HTTP_UNAUTHORIZED);
        }

        if ($this->username($request->login) === 'email' && (auth()->user() instanceof MustVerifyEmail && !auth()->user()->hasVerifiedEmail())) {
            return response()->json(['message' => trans('system.email.unverify'), 'verify' => false], Response::HTTP_FORBIDDEN);
        }

//        dd($token->plainTextToken);

        return $this->respondWithToken($token->plainTextToken);
    }

    protected function conditions(Request $request): array
    {
        return [
            $this->loginVia => $request->login,
        ];
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'login' => check_login_type($request->login) ? 'required|email' : 'required|min:10',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            $this->username($request->login) => $request->login,
            'password' => $request->password,
            'status' => User::STATUS_APPROVED,
            //'domain' => $request->header('client')
        ];
    }

    /**
     * @api {post} /api/v1/auth/refresh 3. Восстановить токен
     * @apiVersion 1.0.0
     * @apiName AuthRefresh
     * @apiGroup 02.Авторизация
     * @apiDescription Восстановить Bearer токен, по времени истечения
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @api {post} /api/v1/auth/logout 4. Выход
     * @apiVersion 1.0.0
     * @apiName AuthLogout
     * @apiGroup 02.Авторизация
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
