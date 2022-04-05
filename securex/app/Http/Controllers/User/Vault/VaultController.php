<?php

namespace App\Http\Controllers\User\Vault;

use App\Http\Controllers\Controller;
use App\Models\Vaults\Vault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class VaultController extends Controller
{
    /**
     * Return Sites not added to any Folder.
     */
    protected function getOpenSites($get_sites)
    {
        $s = null;

        foreach ($get_sites as $site) {
            if ($site->folder->isEmpty()) {
                $s[] = $site;
            }
        }

        $sites = collect($s);

        return $sites;
    }

    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    // Display the main Vaults page
    public function index(Request $request)
    {
        $vaults = Auth::user()->vaults()->get();

        return view('main.vaults.index')->with(compact('vaults'));
    }

    // Display Contents of a Selected Vault
    public function select(Vault $vault)
    {
        $this->authorize('update', $vault);

        $sites = $this->getOpenSites($vault->sites);

        if ($vault->password) {
            if (session()->has($vault->id . '-pass')) {
                return view('main.vaults.select.index')->with(compact('vault', 'sites'));
            }

            return view('main.vaults.select.authenticate')->with(compact('vault'));
        }

        return view('main.vaults.select.index')->with(compact('vault', 'sites'));
    }

    // Authenticate & unlock a Password Protected Vault
    public function authenticate(Request $request, Vault $vault)
    {
        $input = $request->all();

        if (Hash::check($request->password, $vault->password)) {
            $request->session()->put($vault->id . '-pass', true);

            laraflash($vault->name . ' ' . Lang::get('alerts.vault.unlocked'), Lang::get('alerts.congrats'))->info();

            return back();
        }

        laraflash(Lang::get('alerts.vault.incorrect_password'), Lang::get('alerts.warning'))->danger();

        return back();
    }

    // Lock an Unlocked Vault
    public function lockVault(Vault $vault)
    {
        session()->forget($vault->id . '-pass');

        laraflash($vault->name . ' ' . Lang::get('alerts.vault.locked'), Lang::get('alerts.alert'))->warning();

        return redirect()->route('vaults');
    }
}
