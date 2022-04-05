<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Console\Output\BufferedOutput;

class LaravelShortcutsController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin', 'password.confirm']);
    }

    // Clear Cache File
    public function clearCache()
    {
        $exitCode = Artisan::call('cache:clear');
        laraflash(Lang::get('alerts.admin.laravel.cache_clear'), Lang::get('alerts.success'))->success();

        return back();
    }

    // Clear View File
    public function clearView()
    {
        $exitCode = Artisan::call('view:clear', []);
        laraflash(Lang::get('alerts.admin.laravel.view_clear'), Lang::get('alerts.success'))->success();

        return back();
    }

    // Clear Route File
    public function clearRoute()
    {
        $exitCode = Artisan::call('route:clear', []);
        laraflash(Lang::get('alerts.admin.laravel.route_clear'), Lang::get('alerts.success'))->success();

        return back();
    }

    // Clear Config File
    public function clearConfig()
    {
        $exitCode = Artisan::call('config:clear', []);
        laraflash(Lang::get('alerts.admin.laravel.config_clear'), Lang::get('alerts.success'))->success();

        return back();
    }

    // Clear Compiled Files
    public function clearCompiled()
    {
        $exitCode = Artisan::call('clear-compiled', []);
        laraflash(Lang::get('alerts.admin.laravel.clear_compiled'), Lang::get('alerts.success'))->success();

        return back();
    }

    // Create Symlink if not exists
    public function symlink()
    {
        $outputLog = new BufferedOutput();

        Artisan::call('storage:link', [], $outputLog);

        laraflash($outputLog->fetch(), Lang::get('alerts.success'))->success();

        return back();
    }
}
