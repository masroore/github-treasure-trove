<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Mail\Alerts\UserAccountBanned;
use App\Mail\Alerts\UserAccountUnbanned;
use App\Models\Users\User;
use App\Notifications\User\AccountBanned;
use App\Notifications\User\AccountUnBanned;
use App\Notifications\User\EmailChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin']);
    }

    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Return profile of a user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Change the Email Address of the user.
     *
     * @param model $user
     */
    public function changeEmail(User $user, Request $request)
    {
        $messages = [
            'current_email.required' => Lang::get('alerts.admin.users.validation.current_email_required'),
            'email.required' => Lang::get('alerts.admin.users.validation.email_required'),
            'email.unique' => Lang::get('alerts.admin.users.validation.email_unique'),
            'pin.required' => Lang::get('alerts.admin.users.validation.pin_required'),
            'pin.digits' => Lang::get('alerts.admin.users.validation.pin_digits'),
        ];

        $this->validate($request, [
            'current_email' => 'required|email',
            'email' => 'required|unique:users',
            'pin' => 'required|digits:4',
        ], $messages);

        if ($user->email != $request->current_email) {
            laraflash(Lang::get('alerts.admin.users.current_email_fail'), Lang::get('alerts.sorry'))->danger();

            return back();
        }

        if ($user->email === $request->email) {
            laraflash(Lang::get('alerts.admin.users.new_email_same'), Lang::get('alerts.warning'))->danger();

            return back();
        }

        if ($user->support_pin === $request->pin) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();
            $request->user()->sendEmailVerificationNotification();
            $user->notify(new EmailChanged());
            laraflash(Lang::get('alerts.admin.users.email_updated'), Lang::get('alerts.success'))->success();

            return back();
        }

        laraflash(Lang::get('alerts.admin.users.support_pin_incorrect'), Lang::get('alerts.sorry'))->danger();

        return back();
    }

    /**
     * Display the ip logs of a user.
     *
     * @param model $user
     */
    public function iplogs(User $user)
    {
        $logs = $user->auths;

        return view('admin.users.ip-logs', compact('user', 'logs'));
    }

    /**
     * Verify a User's Support PIN.
     *
     * @param model $user
     */
    public function verifyPIN(User $user, Request $request)
    {
        $messages = [
            'support_pin.required' => Lang::get('alerts.admin.users.validation.support_pin_required'),
            'support_pin.digits' => Lang::get('alerts.admin.users.validation.support_pin_digits'),
        ];

        $this->validate($request, [
            'support_pin' => 'required|digits:4',
        ], $messages);

        if ($user->support_pin === $request->support_pin) {
            laraflash(Lang::get('alerts.admin.users.support_pin_verified'), Lang::get('alerts.success'))->success();

            return back();
        }

        laraflash(Lang::get('alerts.admin.users.support_pin_incorrect'), Lang::get('alerts.sorry'))->danger();

        return back();
    }

    /**
     * Ban a user.
     *
     * @param model $user
     */
    public function ban(User $user, Request $request)
    {
        $this->validate($request, [
            'confirm' => 'required',
            'remark' => 'required',
        ]);

        if ($request->confirm) {
            if ($user->status === 'Banned') {
                laraflash(Lang::get('alerts.admin.users.already_banned'), Lang::get('alerts.welp'))->info();

                return back();
            }

            $user->status = 'Banned';
            $user->remark = $request->remark;
            $user->remark_date = Now();
            $user->save();
            $user->notify(new AccountBanned($request->remark));
            Mail::to($user->email)->send(new UserAccountBanned($user));
            laraflash(Lang::get('alerts.admin.users.banned'), Lang::get('alerts.success'))->success();

            return back();
        }

        laraflash(Lang::get('alerts.admin.users.confirmed_required'), Lang::get('alerts.warning'))->danger();

        return back();
    }

    /**
     * Revoke User Ban.
     *
     * @param model $user
     */
    public function revokeBAN(User $user, Request $request)
    {
        $this->validate($request, [
            'confirm' => 'required',
        ]);

        if ($request->confirm) {
            if ($user->status != 'Banned') {
                laraflash(Lang::get('alerts.admin.users.not_yet_banned'), Lang::get('alerts.welp'))->info();

                return back();
            }

            $user->status = 'Active';
            $user->remark = null;
            $user->remark_date = null;
            $user->save();
            $user->notify(new AccountUnBanned());
            Mail::to($user->email)->send(new UserAccountUnbanned($user));
            laraflash(Lang::get('alerts.admin.users.unbanned'), Lang::get('alerts.success'))->success();

            return back();
        }

        laraflash(Lang::get('alerts.admin.users.confirmed_required'), Lang::get('alerts.warning'))->danger();

        return back();
    }

    /**
     * Permanantly Delete a User Account.
     */
    public function destroy(User $user, Request $request)
    {
        $this->validate($request, [
            'confirm' => 'required',
        ]);

        if ($request->confirm) {
            $user->delete();

            laraflash(Lang::get('alerts.admin.users.deleted_success'), Lang::get('alerts.success'))->success();

            return redirect()->route('admin.users.index');
        }

        laraflash(Lang::get('alerts.admin.users.confirmed_required'), Lang::get('alerts.warning'))->danger();

        return back();
    }
}
