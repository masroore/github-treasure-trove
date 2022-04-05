<?php

// https://laracasts.com/discuss/channels/eloquent/updateorcreate-increment-value-depending-on-update-or-set-to-1-if-its-an-insert

namespace App\Http\Middleware;

use App\Models\AccessList;
use App\Models\AccessLog;
use App\Models\Counter;
use Carbon\Carbon;
use Closure;

class CounterCheck
{
    public function handle($request, Closure $next)
    {
        $dateNow = date('Y-m-d');

        $dt = Carbon::now();
        $yy = $dt->year;
        $mm = $dt->month;
        $dd = $dt->day;
        // $hh = $dt->hour ;
        $date = $dt->toDateString();
        // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
        $day_of_week = $dt->dayOfWeek;
        $unique_view = 0;

        $remote_ip = $request->ip();
        $user_agent = $request->header('user-agent');

        $access_log = AccessLog::where('date', $dateNow)
            ->where('remote_ip', $remote_ip)->where('user_agent', $user_agent);
        if ($access_log->count() == 0) {
            $data = [
                'yy' => $yy,
                'mm' => $mm,
                'dd' => $dd,
                // 'hh'=> $hh,
                'date' => $date,
                'remote_ip' => $remote_ip,
                'user_agent' => $user_agent,
            ];
            AccessLog::create($data);
        }

        $unique_view = AccessLog::where('date', $dateNow)->count();

        // updateOrCreate

        $counter = Counter::updateOrCreate(
            [
                'yy' => $yy,
                'mm' => $mm,
                'dd' => $dd,
                // 'date'=> $dateNow,
                'day_of_week' => $day_of_week,
                'date' => $dateNow,
            ],
            [
                // 'page_view' =>  1,
                'unique_view' => $unique_view,
            ]
        );
        if (!$counter->wasRecentlyCreated) {
            $counter->increment('page_view');
        }

        $access_lists = AccessList::where('remote_ip', $remote_ip)->where('user_agent', $user_agent);

        if ($access_lists->count() == 0) {
            $data = [
                'remote_ip' => $remote_ip,
                'user_agent' => $user_agent,
                'ccount' => 1,
            ];
            AccessList::create($data);
        } else {
            $access_list = $access_lists->first();
            $count = $access_list->count;
            $access_list2 = AccessList::find($access_list->id);
            $access_list2->count = $count + 1;
            $access_list2->save();
        }

        return $next($request);
    }
}
