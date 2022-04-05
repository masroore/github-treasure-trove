<?php

namespace App\Http\Controllers\User\Vault;

use App\Http\Controllers\Controller;
use App\Mail\Alerts\VaultDeleted as AlertsVaultDeleted;
use App\Models\Users\User;
use App\Models\Vaults\Vault;
use App\Notifications\User\VaultDeleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;

class VaultSettingsController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->middleware('password.confirm')->only('deleteSettings');
    }

    /**
     * Display settings page for the Vault.
     *
     * @param model $vault
     */
    public function index(Vault $vault)
    {
        if (!$vault->checkPass($vault)) {
            return view('main.vaults.select.authenticate')->with(compact('vault'));
        }

        return view('main.vaults.select.settings.general')->with(compact('vault'));
    }

    /**
     * Display password settings page for the Vault.
     *
     * @param model $vault
     */
    public function passwordSettings(Vault $vault)
    {
        $this->authorize('update', $vault);

        if (!$vault->checkPass($vault)) {
            return view('main.vaults.select.authenticate')->with(compact('vault'));
        }

        return view('main.vaults.select.settings.password')->with(compact('vault'));
    }

    /**
     * Update Password Settings of the Vault.
     *
     * @param array $request
     * @param model $vault
     */
    public function storePasswordSettings(Request $request, Vault $vault)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $this->authorize('update', $vault);

        $vault->update(['password' => Hash::make($request->password)]);

        $request->session()->forget($vault->id . '-pass');

        laraflash($vault->name . ' ' . Lang::get('alerts.vault.password_updated'), Lang::get('alerts.success'))->success();

        return redirect()->route('vaults.select.settings.password', $vault);
    }

    /**
     * Delete Password for the Vault.
     *
     * @param array $request
     * @param model $vault
     */
    public function deletePasswordSettings(Request $request, Vault $vault)
    {
        $this->authorize('update', $vault);

        if (!Hash::check($request->password, $vault->password)) {
            laraflash(Lang::get('alerts.vault.password_invalid'), Lang::get('alerts.warning'))->danger();

            return back();
        }

        $vault->update(['password' => null]);

        $request->session()->forget($vault->id . '-pass');

        laraflash($vault->name . ' ' . Lang::get('alerts.vault.password_removed'), 'Alert!')->warning();

        return redirect()->route('vaults.select.settings.password', $vault);
    }

    /**
     * Display the page for deleting the Vault.
     *
     * @param model $vault
     */
    public function deleteSettings(Vault $vault)
    {
        $this->authorize('update', $vault);

        return view('main.vaults.select.settings.delete')->with(compact('vault'));
    }

    /**
     * Deleting the Vault & all related data.
     *
     * @param array $request
     * @param model $vault
     */
    public function deleteVault(Request $request, Vault $vault)
    {
        // Check if Vault has password protection and verify.
        if ($vault->password) {
            if (!Hash::check($request->password, $vault->password)) {
                laraflash(Lang::get('alerts.vault.password_invalid'), Lang::get('alerts.warning'))->danger();

                return back();
            }
        }

        $user = Auth::user();

        // Check if 2-Step Auth is activated and verify.
        if ($user->is_2fa_enabled) {
            $google2fa = new Google2FA();

            $otp = $request->otp;

            $window = 8;

            $valid = $google2fa->verifyKey($user->google2fa_secret, $otp, $window);

            if (!$valid) {
                laraflash(Lang::get('alerts.security.validation.otp_invalid'), Lang::get('alerts.warning'))->danger();

                return back();
            }
        }

        // Delete any session for the vault.
        $request->session()->forget($vault->id . '-pass');

        // Detach all the sites from folders in the vault.
        foreach ($vault->folders as $folder) {
            foreach ($folder->sites as $site) {
                $folder->sites()->detach($site);
            }
        }

        // Delete all the sites in the vault.
        $vault->sites()->delete();

        // Delete all the folders in the vault,
        $vault->folders()->delete();

        // Sending notification to user.
        $user->notify(new VaultDeleted($vault));

        if (setting()->get('app_email_alerts') === 'true') {
            Mail::to($user->email)->send(new AlertsVaultDeleted($user, $vault));
        }

        // Delete the vault.
        $vault->delete();

        laraflash(Lang::get('alerts.vault.deleted'), Lang::get('alerts.success'))->success();

        return redirect()->route('vaults');
    }
}
