<?php

namespace App\Http\Controllers\User\Security;

use App\Http\Controllers\Controller;
use App\Mail\Alerts\TwoStepDisabled;
use App\Mail\Alerts\TwoStepEnabled;
use App\Notifications\User\TSADisabled;
use App\Notifications\User\TSAEnabled;
use App\Notifications\User\TSAKeyReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;

class SecurityController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa'])->except(['disable2FAView', 'disable2FA']);
    }

    // Main Security View Page
    public function index()
    {
        $user = Auth::user();

        if ($user->security_questions) {
            $google2fa = new Google2FA();
            $google2fa_url = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                decrypt($user->two_factor_secret)
            );

            return view('main.security.index', ['google2fa_url' => $google2fa_url]);
        }

        $google2fa_url = 'Null';

        return view('main.security.index', ['google2fa_url' => $google2fa_url]);
    }

    /**
     * Activating Two-Factor Authentication (2FA).
     */
    public function activate2FA(Request $request)
    {
        $messages = [
            'otp.required' => Lang::get('alerts.security.validation.otp_required'),
            'otp.digits' => Lang::get('alerts.security.validation.otp_digits'),
        ];

        $this->validate($request, [
            'otp' => 'required|digits:6',
        ], $messages);

        $user = Auth::user();

        $otp = $request->otp;

        $google2fa = new Google2FA();

        $window = 8;

        $valid = $google2fa->verifyKey(decrypt($user->two_factor_secret), $otp, $window);

        if ($valid) {
            $user->two_factor_enabled = true;
            $user->save();
            $request->session()->put('2fa', time());

            $user->notify(new TSAEnabled());

            if (setting()->get('app_email_alerts') === 'true') {
                Mail::to($user->email)->send(new TwoStepEnabled($user));
            }

            laraflash(Lang::get('alerts.security.two_step_success'), Lang::get('alerts.congrats'))->success();

            return back();
        }

        laraflash(Lang::get('alerts.security.validation.otp_invalid'), Lang::get('alerts.warning'))->danger();

        return back();
    }

    /**
     * Deactivating 2FA.
     *
     * @param string @confirmation
     * @param string @password
     * @param int @otp
     */
    public function deactivate2FA(Request $request)
    {
        $messages = [
            'otp.required' => Lang::get('alerts.security.validation.otp_required'),
            'otp.digits' => Lang::get('alerts.security.validation.otp_digits'),
            'confirmation.required' => Lang::get('alerts.security.confirmation_required'),
            'password.required' => Lang::get('alerts.profile.validation.password_required'),
        ];

        $this->validate($request, [
            'otp' => 'required|numeric|digits:6',
            'confirmation' => 'required',
            'password' => 'required|password',
        ], $messages);

        if ($request->confirmation) {
            $otp = $request->otp;

            $user = Auth::user();

            $google2fa = new Google2FA();

            $window = 8;

            $valid = $google2fa->verifyKey(decrypt($user->two_factor_secret), $otp, $window);

            if ($valid) {
                $user->two_factor_enabled = false;
                $user->save();

                $request->session()->forget('2fa');
                $user->notify(new TSADisabled());

                if (setting()->get('app_email_alerts') === 'true') {
                    Mail::to($user->email)->send(new TwoStepDisabled($user));
                }

                laraflash(Lang::get('alerts.security.two_step_disabled'), Lang::get('alerts.warning'))->warning();

                return back();
            }

            laraflash(Lang::get('alerts.security.validation.otp_invalid'), Lang::get('alerts.warning'))->danger();

            return back();
        }

        laraflash(Lang::get('alerts.security.confirmation_required'), Lang::get('alerts.warning'))->danger();

        return back()->withErrors('Deactivation Confirmation is required.');
    }

    /**
     * Disable 2FA Without Phone View.
     */
    public function disable2FAView()
    {
        return view('main.security.disable2FA');
    }

    /**
     * Reset Google2fa Secret & QR Code.
     */
    public function reset2FA()
    {
        $user = Auth::user();

        if ($user->security_questions) {
            $google2fa = new Google2FA();

            $user->two_factor_secret = encrypt($google2fa->generateSecretKey(16));

            $user->save();

            $user->notify(new TSAKeyReset());

            laraflash(Lang::get('alerts.security.two_step_reset'), Lang::get('alerts.success'))->success();

            return back();
        }

        laraflash(Lang::get('alerts.security.setup_questions'), Lang::get('alerts.alert'))->danger();

        return back();
    }
}
