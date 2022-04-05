<?php

namespace App\Http\Middleware;

use App;
use App\LandingPageSection;
use App\Utility;
use Auth;
use Closure;

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

            if ('super admin' == Auth::user()->type) {
                $migrations = $this->getMigrations();
                $dbMigrations = $this->getExecutedMigrations();
                $numberOfUpdatesPending = \count($migrations) - \count($dbMigrations);

                if ($numberOfUpdatesPending > 0) {
                    return redirect()->route('LaravelUpdater::welcome');
                }

                $landingData = LandingPageSection::all()->count();
                if (0 == $landingData) {
                    Utility::add_landing_page_data();
                }
            }
        }

        $input = $request->all();
        array_walk_recursive(
            $input,
            function (&$input): void {
                $input = strip_tags($input);
            }
        );
        $request->merge($input);

        return $next($request);
    }
}
