<?php

namespace App\Http\Middleware;

use App\Models\Back\Users\Client;
use Bouncer;
use Closure;

class RedirectIfEmptyClientData
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (Bouncer::is(auth()->user())->an('editor')) {
            $client = Client::where('user_id', auth()->user()->id)->first();

            if (!$client) {
                return redirect()->route('profile')->with(['warning' => 'Molimo ispunite potrebne podatke da biste mogli nastaviti..!']);
            }
        }

        return $next($request);
    }
}
