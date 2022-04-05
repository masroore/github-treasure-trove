<?php

namespace App\Http\Controllers\Admin;

use App\AccessList;
// use benhall14\phpCalendar\Calendar;
use App\Counter;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaticsController extends Controller
{
    public function makeTwo($val)
    {
        if (strlen($val) == 1) {
            return '0' . $val;
        }

        return $val;
    }

    public function index(Request $request)
    {
        // dd($request->all());

        // $calendar = new Calendar();
        // $cal= $calendar->draw(date('Y-m-d')); # draw this months calendar
        $today = Carbon::now();
        $yy = $request->yy ?: $today->year;
        $mm = $request->mm ?: $today->month;

        $long_month = [1, 3, 5, 7, 8, 10, 12];
        $short_month = [4, 6, 9, 11];

        $start_day = '01';
        if (in_array($mm, $long_month)) {
            $end_day = '31';
        } elseif (in_array($mm, $short_month)) {
            $end_day = '30';
        } else {
            $end_day = '28';
        }

        // $mm = $this->makeTwo($mm);

        $sdate1 = Carbon::createFromDate($yy, $mm, 1);
        $sdate = implode('-', [$yy, $mm, 1]);
        // / dayOfWeek returns a number between 0 (sunday) and 6 (saturday)

        $s_day_of_week = $sdate1->dayOfWeek;

        $edate = Carbon::createFromDate($yy, $mm, $end_day);
        $edate = implode('-', [$yy, $mm, $end_day]);

        $ref = Carbon::now()->addMinutes(-10);
        // $realtime_access = AccessList::whereBetween('updated_at', [$ref, $now])->count();

        $realtime_access = AccessList::where('updated_at', '>=', $ref)->where('updated_at', '<=', $today)->count();
        $counters = Counter::whereBetween('date', [$sdate, $edate])->get();

        return view('admin.statics.index')
            ->with('realtime_access', $realtime_access)
            ->with('counters', $counters)
            ->with('today', $today)
            ->with('end_day', $end_day)
            ->with('yy', $yy)
            ->with('mm', $mm)
            ->with('s_day_of_week', $s_day_of_week);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
