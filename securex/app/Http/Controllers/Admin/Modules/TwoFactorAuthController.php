<?php

namespace App\Http\Controllers\Admin\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TwoFactorAuthController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin']);
    }

    /**
     * View the Two Factor Auth config page.
     */
    public function index()
    {
        return view('admin.modules.tfa.index');
    }

    /**
     * Update Two Factor Auth Settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'tfa_show_key' => 'required',
            'tfa_show_alert' => 'required',
        ]);

        if ($request->tfa_show_key == 'true') {
            setting()->set('tfa_show_key', true);
        } else {
            setting()->set('tfa_show_key', false);
        }

        if ($request->tfa_show_alert == 'true') {
            setting()->set('tfa_show_alert', true);
        } else {
            setting()->set('tfa_show_alert', false);
        }

        setting()->save();

        laraflash(Lang::get('alerts.admin.modules.tfa.updated'), Lang::get('alerts.success'))->success();

        return redirect()->route('admin.modules.index');
    }
}
