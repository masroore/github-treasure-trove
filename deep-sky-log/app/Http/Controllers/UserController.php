<?php

/**
 * User Controller.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * User Controller.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class UserController extends Controller
{
    /**
     * Make sure the user pages can be seen if the user is authenticated,
     * administrator and verified.
     */
    public function __construct()
    {
        // isAdmin middleware lets only users with a
        // specific permission to access these resources
        $this->middleware(['auth', 'verified'])->except(['getImage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug the user slug to show
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $obsPerYear = $this->chartObservationsPerYear($user);
        $obsPerMonth = $this->chartObservationsPerMonth($user);

        $media = $this->getImage($slug);

        $observationTypes = \App\Models\ObservationType::all();

        foreach ($observationTypes as $type) {
            $numberOfObjects[$type->type]
                = \App\Models\ObservationType::targetCount($type->type);
        }

        return view(
            'users.view',
            [
                'user' => $user, 'observationsPerYear' => $obsPerYear,
                'observationsPerMonth' => $obsPerMonth, 'media' => $media,
                'observationTypes' => $observationTypes,
                'numberOfObjects' => $numberOfObjects,
            ]
        );
    }

    /**
     * Makes the chart with the observations per year.
     *
     * @param User $user The User object
     *
     * @return Chart The chart to display
     */
    protected function chartObservationsPerYear($user)
    {
        // TODO: Use https://charts.erik.cat/ here for charts!
        // TODO: https://dev.to/arielmejiadev/use-laravel-charts-in-laravel-5bbm
        //     $altChart = new AltitudeChart;

        //     // Start at noon
        //     $date->hour = 12;

        //     $hours = [];
        //     $altitude = [];

        //     for ($i = 0; $i < 24;$i++) {
        //         $hours[] = $date->isoFormat('HH:mm');

        //         // Calculate the apparent siderial time
        //         $siderial_time = Time::apparentSiderialTime($date, $geo_coords);

        //         // Calculate the horizontal coordinates
        //         $horizontal = $this->getEquatorialCoordinatesToday()
        //             ->convertToHorizontal(
        //                 $geo_coords,
        //                 $siderial_time
        //             );

        //         $altitude[] = $horizontal->getAltitude()->getCoordinate();

        //         // Add an hour
        //         $date->addHour();
        //     }

        //     $altChart->labels(
        //         $hours
        //     );

        //     $altChart->dataset(
        //         _i('Altitude'),
        //         'spline',
        //         $altitude
        //     );

        //     $altChart->options(
        //         [
        //             'title' => [
        //                 'text' => null,
        //             ],
        //             'yAxis' => [
        //                 'endOnTick' => false,
        //                 'startOnTick' => false,
        //                 'tickInterval' => 30,
        //                 'min' => -90,
        //                 'max' => 90,
        //                 'title' => [
        //                     'text' => _i('Altitude (in ??)'),
        //                 ],
        //             ],
        //             'xAxis' => [
        //                 'zoomEnabled' => true
        //             ],
        //             'tooltip' => [
        //                 'valueDecimals' => 1,
        //                 'valueSuffix' => '??',
        //             ]
        //         ],
        //         true
        //     );

        //     $this->_altitudeChart = $altChart;
        // }

        return \Chart::title(
            [
                'text' => _i('Number of observations per year: ') . $user->name,
            ]
        )->chart(
            [
                // pie , columnt etc
                'type' => 'line',
                // render the chart into your div with id
                'renderTo' => 'observationsPerYear',
                'zoomType' => 'x',
            ]
        )->subtitle(
            [
                'text' => _i('Source: ') . 'https://www.deepskylog.org/',
            ]
        )->xaxis(
            [
                'categories' => [
                    '2009',
                    '2010',
                    '2011',
                    '2012',
                    '2013',
                    '2014',
                    '2015',
                    '2016',
                    '2017',
                    '2018',
                    '2019',
                ],
                'labels' => [
                    'rotation' => 0,
                    'align' => 'top',
                    //'formatter' => 'startJs:function(){return this.value}:endJs',
                    // use 'startJs:yourjavasscripthere:endJs'
                ],
            ]
        )->yaxis(
            [
                'title' => ['text' => _i('Observations')],
            ]
        )->legend(
            [
                'layout' => 'vertikal',
                'align' => 'right',
                'verticalAlign' => 'middle',
            ]
        )->series(
            [
                [
                    'name' => _i('Total'),
                    'data' => [124, 439, 525, 571, 696, 0, 100, 324, 129, 77, 12],
                ],
                [
                    'name' => _i('Deepsky'),
                    'data' => [120, 400, 423, 333, 500, 0, 77, 11, 12, 7, 4],
                ],
                [
                    'name' => _i('Comets'),
                    'data' => [23, 10, 23, 33, 50, 0, 7, 15, 66, 23, 1],
                ],
                [
                    'name' => _i('Double stars'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3],
                ],
                [
                    'name' => _i('Planets and moons'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3],
                ],
                [
                    'name' => _i('Sun'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3],
                ],
                [
                    'name' => _i('Moon'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3],
                ],
            ]
        )->display();
    }

    /**
     * Makes the chart with the observations per month.
     *
     * @param User $user The User object
     *
     * @return Chart The chart to display
     */
    protected function chartObservationsPerMonth($user)
    {
        return \Chart::title(
            [
                'text' => _i('Number of observations per month: ') . $user->name,
            ]
        )->chart(
            [
                // pie , columnt etc
                'type' => 'column',
                // render the chart into your div with id
                'renderTo' => 'observationsPerMonth',
            ]
        )->plotOptions(
            [
                'column' => ['stacking' => 'normal'],
            ]
        )->subtitle(
            [
                'text' => _i('Source: ') . 'https://www.deepskylog.org/',
            ]
        )->xaxis(
            [
                // Add months of the year (short version)
                'categories' => [
                    Carbon::parse('2018-01-20')->isoFormat('MMM'),
                    Carbon::parse('2018-02-20')->isoFormat('MMM'),
                    Carbon::parse('2018-03-20')->isoFormat('MMM'),
                    Carbon::parse('2018-04-20')->isoFormat('MMM'),
                    Carbon::parse('2018-05-20')->isoFormat('MMM'),
                    Carbon::parse('2018-06-20')->isoFormat('MMM'),
                    Carbon::parse('2018-07-20')->isoFormat('MMM'),
                    Carbon::parse('2018-08-20')->isoFormat('MMM'),
                    Carbon::parse('2018-09-20')->isoFormat('MMM'),
                    Carbon::parse('2018-10-20')->isoFormat('MMM'),
                    Carbon::parse('2018-11-20')->isoFormat('MMM'),
                    Carbon::parse('2018-12-20')->isoFormat('MMM'),
                ],
                'labels' => [
                    'rotation' => 0,
                    'align' => 'center',
                    //'formatter' => 'startJs:function(){return this.value}:endJs',
                    // use 'startJs:yourjavasscripthere:endJs'
                ],
            ]
        )->yaxis(
            [
                'title' => ['text' => _i('Observations')],
            ]
        )->legend(
            [
                'layout' => 'vertikal',
                'align' => 'right',
                'verticalAlign' => 'middle',
            ]
        )->series(
            [
                [
                    'name' => _i('Deepsky'),
                    'data' => [120, 400, 423, 333, 500, 0, 77, 11, 12, 7, 4, 6],
                ],
                [
                    'name' => _i('Comets'),
                    'data' => [23, 10, 23, 33, 50, 0, 7, 15, 66, 23, 1, 7],
                ],
                [
                    'name' => _i('Double stars'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3, 8],
                ],
                [
                    'name' => _i('Planets and moons'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3, 9],
                ],
                [
                    'name' => _i('Sun'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3, 10],
                ],
                [
                    'name' => _i('Moon'),
                    'data' => [12, 3, 9, 22, 30, 0, 12, 18, 77, 18, 3, 11],
                ],
            ]
        )->display();
    }

    /**
     * Display the settings page for the observer.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        if (auth()->user()->id == $user->id) {
            return view('users.settings', ['user' => $user]);
        }
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug the user slug to edit
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //Get user with specified slug
        $user = User::where('slug', $slug)->firstOrFail();
        //pass user data to view
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request The request
     * @param string      $slug    The slug of the user to update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $slug)
    {
        // Get user specified by slug
        $user = User::where('slug', $slug)->firstOrFail();

        // Validate name, email and password fields
        $request->validated();

        // Retrieve the name, email and password fields
        $input = $request->only(['username', 'name', 'email', 'type']);

        $user->type = $request['type'];

        $user->fill($input)->save();

        laraflash(_i('User %s successfully edited.', $user->name))->success();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $slug the user slug of the user to delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //Find a user with a given slug and delete
        $user = User::where('slug', $slug)->firstOrFail();

        laraflash(_i('User %s successfully deleted.', $user->name))->warning();

        $user->delete();

        return redirect()->route('users.index');
    }

    /**
     * Returns the image of the observer.
     *
     * @param string $slug The observer slug
     *
     * @return MediaObject the image of the observer
     */
    public function getImage($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        if (!$user->hasMedia('observer')) {
            $this->addDefaultMedia($user);
        }

        return $user->getFirstMedia('observer');
    }

    private function addDefaultMedia($user): void
    {
        $user->addMediaFromUrl(asset('images/profile.png'))
            ->usingFileName($user->id . '.png')
            ->toMediaCollection('observer');
    }

    /**
     * Remove the image of the observer.
     *
     * @param int $id The id of the observer
     *
     * @return None
     */
    public function deleteImage($id)
    {
        User::find($id)
            ->getFirstMedia('observer')
            ->delete();

        return '{}';
    }

    /**
     * Returns the image of the observer.
     *
     * @return MediaObject the image of the observer
     */
    public function getAuthenticatedUserImage()
    {
        $id = auth()->user()->id;
        if (User::find($id)->hasMedia('observer')) {
            return User::find($id)
                ->getFirstMedia('observer');
        }
        User::find($id)
            ->addMediaFromUrl(asset('img/profile.png'))
            ->usingFileName($id . '.png')
            ->toMediaCollection('observer');

        return User::find($id)
            ->getFirstMedia('observer');
    }

    /**
     * Patch the settings for the observer.
     *
     * @param Request $request The request object with all information
     * @param string  $slug    The id of the observer
     *
     * @return None
     */
    public function patchSettings(Request $request, $slug)
    {
        // The authenticated user
        $user = auth()->user();

        // Update the language for the user interface
        if ($request->has('language')) {
            $user->update(
                ['language' => $request->get('language')]
            );
        }

        // Update the language for the observations
        if ($request->has('observationlanguage')) {
            $user->update(
                ['observationlanguage' => $request->get('observationlanguage')]
            );
        }

        return redirect()->back();
    }
}
