<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Notifications\User\PasswordResetRequested;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * Redirect to HOME if the user is authenticated.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        if (Auth::guest()) {
            return view('auth.passwords.email');
        }

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        $user = User::where('email', $request->email)->first();

        $user->notify(new PasswordResetRequested());

        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($response)], 200)
            : back()->with('status', trans($response));
    }
}
