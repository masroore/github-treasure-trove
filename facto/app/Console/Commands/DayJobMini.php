<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DayJobMini extends Command
{
    protected $signature = 'mini:day {mode?}';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $mode = $this->argument('mode');
        if ($mode == 'today') {
            $date_index = Carbon::today()->toDateString();
            $sdate = Carbon::today()->toDateString();
            $edate = Carbon::today()->toDateString();
        } else {
            sleep(10);

            $date_index = Carbon::yesterday()->toDateString();
            $sdate = Carbon::yesterday()->toDateString();
            $edate = Carbon::yesterday()->toDateString();
        }
        $stime = $sdate . ' 00:00:00';
        $etime = $edate . ' 23:59:59';

        $total_charge = Coin::whereBetween('created_at', [$stime, $etime])
            ->where('div', 'charge')
            ->where('status', 'confirmed')
            ->sum('amount');
        $total_withdraw = Coin::whereBetween('created_at', [$stime, $etime])
            ->where('div', 'withdraw')
            ->where('status', 'confirmed')
            ->sum('amount');

        $total_exchange = $total_charge - $total_withdraw;
        $coins_by_admin = Coin::whereBetween('created_at', [$stime, $etime])
            ->where('div', 'charge_by_admin')
            ->where('status', 'confirmed')
            ->sum('amount');
        $points_by_admin = Point::whereBetween('created_at', [$stime, $etime])
            ->where('div', 'charge_by_admin')
            ->where('status', 'confirmed')
            ->sum('amount');

        $count_betters = Betting::whereBetween('created_at', [$stime, $etime])
            ->where('status', '<>', 'cancel')
            ->groupBy('user_id')
            ->count();
        $count_bettings = Betting::whereBetween('created_at', [$stime, $etime])
            ->where('status', '<>', 'cancel')
            ->count();

        $total_betting_coin = Betting::whereBetween('created_at', [$stime, $etime])
            ->where('status', '<>', 'cancel')
            ->where('chip', 'coin')
            ->sum('amount');

        $total_betting_point = Betting::whereBetween('created_at', [$stime, $etime])
            ->where('status', '<>', 'cancel')
            ->where('chip', 'point')
            ->sum('amount');

        $total_betting_amount = Betting::whereBetween('created_at', [$stime, $etime])
            ->where('status', '<>', 'cancel')
            ->sum('amount');

        $total_reward_amount = Betting::whereBetween('created_at', [$stime, $etime])
            ->where('result', 'win')
            ->sum('rewards');
        $total_profit = $total_betting_amount - $total_reward_amount;

        if ($mode == 'today') {
            $closing = Closing::updateOrCreate(
                ['date_index' => $date_index],
                [
                    'total_charge' => $total_charge,
                    'total_withdraw' => $total_withdraw,
                    'total_exchange' => $total_exchange,
                    'coins_by_admin' => $coins_by_admin,
                    'points_by_admin' => $points_by_admin,
                    'count_betters' => $count_betters,
                    'count_bettings' => $count_bettings,
                    'total_betting_coin' => $total_betting_coin,
                    'total_betting_point' => $total_betting_point,
                    'total_betting_amount' => $total_betting_amount,
                    'total_reward_amount' => $total_reward_amount,
                    'total_profit' => $total_profit,
                ]
            );
        } else {
            $closing = Closing::firstOrCreate(
                ['date_index' => $date_index],
                [
                    'total_charge' => $total_charge,
                    'total_withdraw' => $total_withdraw,
                    'total_exchange' => $total_exchange,
                    'coins_by_admin' => $coins_by_admin,
                    'points_by_admin' => $points_by_admin,
                    'count_betters' => $count_betters,
                    'count_bettings' => $count_bettings,
                    'total_betting_coin' => $total_betting_coin,
                    'total_betting_point' => $total_betting_point,
                    'total_betting_amount' => $total_betting_amount,
                    'total_reward_amount' => $total_reward_amount,
                    'total_profit' => $total_profit,
                ]
            );
        }

        if ($closing) {
            echo 'ok' . "\n";
        } else {
            echo 'error' . "\n";
        }
    }
}
