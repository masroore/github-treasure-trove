<?php

namespace App\Http\Middleware;

use App;
use App\Models\LandingPageSection;
use App\Models\Utility;
use Auth;
use Closure;
use DB;
use Illuminate\Support\Facades\Schema;

class XSS
{
    use \RachidLaasri\LaravelInstaller\Helpers\MigrationsHelper;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            App::setLocale(Auth::user()->lang);

            if ('company' == Auth::user()->type) {
                if (Schema::hasTable('ch_messages')) {
                    if (false == Schema::hasColumn('ch_messages', 'type')) {
                        Schema::drop('messages');
                        DB::table('migrations')->where('migration', 'like', '%ch_messages%')->delete();
                    }
                }

                $migrations = $this->getMigrations();
                $dbMigrations = $this->getExecutedMigrations();
                $numberOfUpdatesPending = (\count($migrations) + 6) - \count($dbMigrations);

                if ($numberOfUpdatesPending > 0) {
                    // run code like seeder only when new migration
                    Utility::addNewData();

                    return redirect()->route('LaravelUpdater::welcome');
                }

                $landingData = LandingPageSection::all()->count();
                if (0 == $landingData) {
                    Utility::add_landing_page_data();
                }
            }
        }

        return $next($request);
    }
}
