<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\OAuthProvider;
use App\Models\User;
use Exception;
use function GuzzleHttp\Psr7\build_query;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

final class SocialiteLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @api {post} /api/v1/auth/socialite/{provider} 5. Вход через соц сети
     * @apiVersion 1.0.0
     * @apiName AuthRegister
     * @apiGroup 02.Авторизация
     *
     * @apiDescription Авторизация пользователя
     *
     * @apiParam {String}  provider Социальная сеть <br> Допустимые значения: <code>google, apple, facebook, vkontakte</code>
     */
    public function redirectToProvider(string $provider)
    {
        if ($this->isAllowedProvider($provider) === false) {
            return $this->sendFailedResponse("{$provider} is not currently supported");
        }

        try {
            return [
                'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
            ];
        } catch (Exception $e) {
            return response()->json(['errors' => $this->sendFailedResponse($e->getMessage())]);
        }
    }

    /**
     * Handle response of authentication redirect callback.
     *
     * @return \App\Http\Controllers\Auth\SocialiteController|\Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(string $provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        $user = $this->findOrCreateUser($provider, $user);

        $token = $user->createToken('token');

        $str = build_query(array_merge(['token' => $token->plainTextToken, 'token_type' => 'bearer']));

        return redirect(config('services.frontUrl') . '?' . $str);
    }

    /**
     * Send a successful response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
//    protected function sendSuccessResponse()
//    {
//        return redirect()->intended(RouteServiceProvider::HOME);
//    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedResponse(?string $msg = null)
    {
        return response()->json([
            'errors' => $msg ?: 'Unable to login, try with another provider to login.',
        ]);
    }

    /**
     * Check for provider allowed and services configured.
     *
     * @param $provider
     */
    protected function isAllowedProvider(string $provider): bool
    {
        return in_array($provider, config('services.socialproviders', [])) && config()->has("services.$provider");
    }

    protected function findOrCreateUser($provider, $sUser)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $sUser->getId())
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $sUser->token,
                'refresh_token' => $sUser->refreshToken,
            ]);

            return $oauthProvider->user;
        }

        if (User::where('email', $sUser->getEmail())->exists()) {
            $user = User::where('email', $sUser->getEmail())->first();

            return $user;
        }

        return $this->createUser($provider, $sUser);
    }

    protected function createUser($provider, $sUser)
    {
        $user = User::create([
            'name' => $sUser->getName(),
            'email' => $sUser->getEmail(),
            'email_verified_at' => now(),
            'nickname' => stristr($sUser->getEmail(), '@', true),
        ]);

        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $sUser->getId(),
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
