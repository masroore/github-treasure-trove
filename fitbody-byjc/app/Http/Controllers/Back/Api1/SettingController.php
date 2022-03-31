<?php

namespace App\Http\Controllers\Back\Api1;

use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Profile;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    /**
     * Clear all cache.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        return redirect()->back()->with('success', 'Cache Cleared succesfully!');
    }

    /**
     * Clear config cache.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearConfigCache()
    {
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Config Cache cleared succesfully!');
    }

    /**
     * Clear views cache.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearViewsCache()
    {
        Artisan::call('view:clear');

        return redirect()->back()->with('success', 'View Cache cleared succesfully!');
    }

    /**
     * Clear routes cache.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearRoutesCache()
    {
        Artisan::call('route:clear');

        return redirect()->back()->with('success', 'Routes Cache cleared succesfully!');
    }

    /**
     * Maintenance Mode ON.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maintenanceModeON()
    {
        Artisan::call('down');

        return redirect()->back()->with('success', 'Application is now in maintenance mode.');
    }

    /**
     * Maintenance Mode OFF.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maintenanceModeOFF()
    {
        Artisan::call('up');

        return redirect()->back()->with('success', 'Application is now live.');
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/
    /**
     * @needs_testing
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refreshDatabase()
    {
        $response = Artisan::call('db:seed');

        return redirect()->back()->with('success', 'Database refreshed succesfully!');
    }

    /**
     * @needs_testing
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function composerDump()
    {
        $response = exec('php composer.phar dump-autoload');

        return redirect()->back()->with('success', 'Composer dumped succesfully!');
    }

    public function sidebarInverseToggle()
    {
        return response()->json(
            Profile::updateSidebarInverseToggle(auth()->user()->id)
        );
    }
}
