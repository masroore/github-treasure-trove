<?php

namespace App\Http\Controllers\Api\Auth\Traits;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait ResetsPasswords
{
    /**
     * @api {post} /api/v1/password/reset 2. Сохранение нового пароля юзера
     * @apiVersion 1.0.0
     * @apiName PasswordSave
     * @apiGroup 03.Сброс пароля
     *
     * @apiDescription
     *<br> Сохранение нового пароля. При вызове метода <code>/api/v1/password/email</code> юзер одержит email сообщение
     *<br> ссылка в ньом будет редиректить его на тот домен с которого был одправлен запрос
     *<br> пример <code>cargasm.demka.online/password/reset?token=08615be3fad007c94d32bd2b5dd878678e3a0f3549463f77f93d87ed8cfdfb94&email=admin@app.com</code>
     *<br> нужно создать такой роут на клиенте <code>password/reset</code> который принимает параметры.
     *<br> Эти параметры нужно достать и передать вместе с данными с формы, где юзер будет вводить новые пароли
     *
     * @apiParam {String} email Email пользователя
     * @apiParam {String} token Token для сброса пароля
     * @apiParam {String} password password
     * @apiParam {String} password_confirmation password_confirmation
     */
    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password): void {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     */
    protected function resetPassword($user, $password): void
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     */
    protected function setUserPassword($user, $password): void
    {
        $user->password = Hash::make($password);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return new JsonResponse(['message' => trans($response)], 200);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  string  $response
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        throw ValidationException::withMessages([
            'email' => [trans($response)],
        ]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
