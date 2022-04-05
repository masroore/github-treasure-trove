<?php

namespace App\Http\Controllers\Api\Auth\Traits;

use App\Models\User;
use function GuzzleHttp\Psr7\build_query;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait VerifiesEmails
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {

        /** @var User $user */
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->get('hash'), sha1($user->getEmailForVerification()))) {
            return redirect(config('services.frontUrl') . '/email-verification?status=fail');
        }

        if ($user->hasVerifiedEmail()) {
            $str = build_query(['title' => trans('system.email.fail'), 'status' => 'fail', 'message' => trans('system.email.already')]);

            return redirect(config('services.frontUrl') . '/email-verification?' . $str);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $str = build_query(array_merge(['status' => 'success', 'title' => trans('auth.mail.congratulation'), 'message' => trans('system.email.verify_success'), 'role' => $user->role], $this->getAuthToken($user)));

        return redirect(config('services.frontUrl') . '/email-verification?' . $str);
    }

    protected function getAuthToken(User $user)
    {
        $token = $user->createToken('token');

        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
        ];
    }

    /**
     * @api {post} /api/v1/email/resend 1. Повторная одправка подтверждение email адреса
     * @apiVersion 1.0.0
     * @apiName EmailResend
     * @apiGroup 04.Подтверждение email
     *
     * @apiParam {String} email Email пользователя
     */
    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => trans('system.email.already')], Response::HTTP_BAD_REQUEST);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => trans('system.email.send')], Response::HTTP_OK);
    }
}
