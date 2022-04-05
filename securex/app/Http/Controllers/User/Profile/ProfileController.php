<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Mail\Alerts\AccountDeletionCancelled;
use App\Mail\Alerts\AccountMarkedForDeletion;
use App\Models\Users\MarkForDeletionLog;
use App\Notifications\User\CancelledDeletion;
use App\Notifications\User\MarkedForDeletion;
use App\Notifications\User\MasterPasswordChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class ProfileController extends Controller
{
    // {{ Str::limit(Auth::user()->secret_key, $limit = 8, $end = ' ••• ••••• ••••• ••••• •••••') }}

    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    // Display the User's profile page
    public function index()
    {
        $user = Auth::user();

        return view('main.profile.index')->with(compact('user'));
    }

    // Display the setting's page
    public function settings()
    {
        return view('main.profile.settings');
    }

    /**
     * Update Avatar of a User.
     */
    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/users/avatar/');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
            $user->save();

            laraflash('Avatar Has Been Updated')->success();

            return redirect('profile');
        }
    }

    /**
     * Update Master Password of the User.
     */
    public function updatePassword(Request $request)
    {
        $messages = [
            'master_password.required' => Lang::get('alerts.profile.validation.master_password_required'),
            'master_password.password' => Lang::get('alerts.profile.validation.master_password_password'),
            'otp.digits' => Lang::get('alerts.security.validation.otp_digits'),
            'password.required' => Lang::get('alerts.profile.validation.new_password_required'),
            'password.min' => Lang::get('alerts.profile.validation.new_password_min'),
            'password.confirmed' => Lang::get('alerts.profile.validation.new_password_confirmed'),
        ];

        $this->validate($request, [
            'master_password' => 'required|password',
            'otp' => 'digits:6',
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        $user = Auth::user();

        if ($user->is_2fa_enabled) {
            $otp = $request->otp;
            $window = 8;
            $google2fa = new Google2FA();

            $valid = $google2fa->verifyKey(Auth::user()->google2fa_secret, $otp, $window);

            if (!$valid) {
                laraflash(Lang::get('alerts.security.validation.otp_invalid'), Lang::get('alerts.warning'))->danger();

                return back();
            }
        }
        // Checking if the new password is same as the old password
        if (Hash::check($request->password, $user->password)) {
            laraflash(Lang::get('alerts.profile.validation.password_same'), Lang::get('alerts.warning'))->danger();

            return back();
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        $user->notify(new MasterPasswordChanged());

        laraflash(Lang::get('alerts.profile.master_password_updated'), Lang::get('alerts.success'))->success();

        return back();
    }

    /**
     * Mark user profile for deletion.
     * Profile is deleted after 7-days.
     */
    public function delete()
    {
        $delete_on = \Carbon\Carbon::Now()->addDays(7);

        $user = Auth::user();

        $mark = new MarkForDeletionLog();
        $mark->user_id = $user->id;
        $mark->email = $user->email;
        $mark->action = Lang::get('alerts.profile.marked_for_deletion');
        $mark->ip_address = \Request::ip();
        $mark->user_agent = \Request::header('User-Agent');
        $mark->save();

        $user->delete_on = $delete_on;
        $user->save();

        Mail::to($user->email)->send(new AccountMarkedForDeletion($user));
        $user->notify(new MarkedForDeletion());

        laraflash(Lang::get('alerts.profile.deleted_on') . $delete_on->format('d-M-Y | H:i'), Lang::get('alerts.alert'))->danger();

        return back();
    }

    /**
     * Cancel user profile deletion.
     */
    public function deleteCancel()
    {
        $user = Auth::user();

        $mark = new MarkForDeletionLog();
        $mark->user_id = $user->id;
        $mark->email = $user->email;
        $mark->action = Lang::get('alerts.profile.cancelled_deletion');
        $mark->ip_address = \Request::ip();
        $mark->user_agent = \Request::header('User-Agent');
        $mark->save();

        $user->delete_on = null;
        $user->save();

        Mail::to($user->email)->send(new AccountDeletionCancelled($user));
        $user->notify(new CancelledDeletion());

        laraflash(Lang::get('alerts.profile.no_longer_marked'), Lang::get('alerts.success'))->success();

        return back();
    }

    /**
     * Return list of IP logs for the User.
     */
    public function ipLogs()
    {
        $user = auth()->user();

        $logs = $user->auths;

        return view('main.profile.ip-logs')->with(compact('user', 'logs'));
    }
}
