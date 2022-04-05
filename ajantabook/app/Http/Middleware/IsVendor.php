<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Nwidart\Modules\Facades\Module;

class IsVendor
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $auth = Auth::user();

            if (auth()->user()->getRoleNames() && auth()->user()->getRoleNames()->contains('Seller')) {
                if (Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled()) {
                    if (1 == getPlanStatus()) {
                        return $next($request);
                    }
                    notify()->error('Please subscribe a plan to continue !');

                    return redirect(route('front.seller.plans'));
                }

                return $next($request);
            }

            return abort(401, 'Access denied');
        }

        return abort(401, 'Access denied');
    }
}
