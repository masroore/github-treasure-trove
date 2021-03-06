<?php

/**
 * DeepskyLog middleware. Does some checks and adds a flash message if needed.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

namespace App\Http\Middleware;

use App\Models\Astrolib;
use App\Models\Location;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * DeepskyLog middleware. Does some checks and adds a flash message if needed.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class DeepskyLogChecks
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request The request to handle
     * @param Closure                 $next    the next page / middleware to use
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('date')) {
            $datetime = new \Carbon\Carbon();
            $date = $datetime->format('Y-m-d');
            Session::put('date', $date);
            Astrolib::getInstance()->getAstronomyLibrary()->setDate($datetime);
        } else {
            $date = $request->session()->get('date');
            // $carbonDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
            $carbonDate = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
            // dd($carbonDate);
            Astrolib::getInstance()->getAstronomyLibrary()->setDate($carbonDate);
        }
        if (!Auth::guest()) {
            if (Auth::user()->stdlocation) {
                $location = Location::where('id', Auth::user()->stdlocation)->first();
                Astrolib::getInstance()->setLocation($location);
            }

            // Check if the observer has set a country of residence.
            if (Auth::user()->country === '') {
                laraflash(
                    _i(
                        'Your country of residence is not set. Please set it in the %sobserver settings%s',
                        '<a href="/users/' . Auth::user()->slug . '/settings">',
                        '</a>.'
                    )
                )->warning();
            }

            // Check if a standard location is set
            if (Auth::user()->stdlocation === 0) {
                laraflash(
                    _i('You did not specify a standard location. Please select one.')
                )->warning();
            }

            // Check if the about user information is set
            if (!Auth::user()->about) {
                laraflash(
                    _i(
                        'You did not enter information about yourself. Please set it in the %sobserver settings%s',
                        '<a href="/users/' . Auth::user()->slug . '/settings">',
                        '</a>.'
                    )
                )->warning();
            }

            // Check if there are eyepieces without a brand or a type
            $eyepieces = Auth::user()->eyepieces;
            $eyepieceToCheck = '';
            $eyepieceId = 0;

            foreach ($eyepieces as $eyepiece) {
                if ($eyepiece->brand == '' || $eyepiece->type == '') {
                    $eyepieceToCheck = $eyepiece->name;
                    $eyepieceId = $eyepiece->id;
                }
            }
            if ($eyepieceToCheck != '') {
                laraflash(
                    _i(
                        'At least one of your eyepieces (%s) does not have a brand or a type.
                        Please add the needed information in the %seyepiece page%s',
                        '<a href="/eyepiece/' . $eyepieceId . '">'
                        . $eyepieceToCheck . '</a>',
                        '<a href="/eyepiece/">',
                        '</a>.'
                    )
                )->warning();
            }

            // Check if there are any instruments
            if (count(Auth::user()->instruments) === 0) {
                laraflash(
                    _i(
                        'DeepskyLog will be able to calculate the visibility of objects when you %sadd some instruments%s',
                        '<a href="/instrument/create">',
                        '</a>.'
                    )
                )->warning();
            } else {
                // Check if a standard instrument is set
                if (Auth::user()->stdtelescope === 0) {
                    laraflash(
                        _i('You did not specify a standard instrument. Please select one.')
                    )->warning();
                }
            }
            // Check if there are observing lists without a description
            $lists = \App\Models\ObservationList::where('user_id', Auth::user()->id)->where('discoverable', 1)->get();

            $cnt = 0;
            foreach ($lists as $list) {
                if ($list->description == '') {
                    ++$cnt;
                }
            }
            if ($cnt > 0) {
                laraflash(
                    _i('At least one of your discoverable observing lists does not have a description.') . ' ' .
                    _i(
                        'Please add a description at the %sobserving list page%s.  This way, other observers can easily find your lists and subscribe to them.',
                        '<a href="/observationList/">',
                        '</a>.'
                    )
                )->warning();
            }
        }

        return $next($request);
    }
}
