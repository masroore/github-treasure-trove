<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppSettingUpdateForm;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;

class SystemSettingController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin', 'password.confirm']);
    }

    /**
     * Display the system settings page.
     */
    public function index()
    {
        return view('admin.settings.system.index');
    }

    /**
     * Deactivating Maintenance Mode.
     */
    public function up()
    {
        Artisan::call('up');

        Cookie::queue(Cookie::forget('laravel_maintenance'));

        laraflash(Lang::get('alerts.admin.settings.system.app_live'), Lang::get('alerts.success'))->success();

        return back();
    }

    /**
     * Update app settings.
     *
     * @param request $request
     */
    public function app(AppSettingUpdateForm $request)
    {
        setting()->set('default_membership', $request->default_membership);
        setting()->set('max_vaults', $request->max_vaults);
        setting()->set('max_sites', $request->max_sites);
        setting()->set('max_folders', $request->max_folders);
        setting()->set('max_notes', $request->max_notes);
        setting()->set('app_email_alerts', $request->app_email_alerts);

        laraflash(Lang::get('alerts.admin.settings.system.updated_success'), Lang::get('alerts.success'))->success();

        return back();
    }

    /**
     * Swtiching App to Private Mode.
     */
    public function private()
    {
        setting()->set('app_mode', 'PRIVATE');

        laraflash(Lang::get('alerts.admin.settings.system.private'), Lang::get('alerts.success'))->success();

        return back();
    }

    /**
     * Swtiching App to Public Mode.
     */
    public function public()
    {
        setting()->set('app_mode', 'PUBLIC');

        laraflash(Lang::get('alerts.admin.settings.system.public'), Lang::get('alerts.success'))->success();

        return back();
    }
}
