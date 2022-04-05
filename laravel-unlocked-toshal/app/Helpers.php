<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('change_date_format')) {
    function change_date_format(string $date, string $format = 'd F Y')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}
if (!function_exists('get_timestamp')) {
    function get_timestamp()
    {
        return Carbon::now()->timestamp;
    }
}
if (!function_exists('getDifferenceInSecond')) {
    function getDifferenceInSecond($startTime, $finishTime)
    {
        $startTime = date('Y-m-d h:i:s', $startTime);
        $finishTime = date('Y-m-d h:i:s', $finishTime);
        $startTime = Carbon::parse($startTime);
        $finishTime = Carbon::parse($finishTime);

        return $totalDuration = $finishTime->diffInSeconds($startTime);
    }
}
if (!function_exists('get_1_month_old_date')) {
    function get_1_month_old_date()
    {
        $date = date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d'))) . '-1 month'));

        return $date;
    }
}
if (!function_exists('add_days_to_date')) {
    function add_days_to_date(string $date, string $days)
    {
        if ($days == 'Monthly') {
            $no_of_days = 30;
        } elseif ($days == 'Quaterly') {
            $no_of_days = 91;
        } elseif ($days == 'HalfYearly') {
            $no_of_days = 182;
        } elseif ($days == 'Annually') {
            $no_of_days = 365;
        }
        $expiry_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        $expiry_date = $expiry_date->addDays($no_of_days);
        $expiry_date = \Carbon\Carbon::parse($expiry_date)->format('Y-m-d');

        return $expiry_date;
    }
}
if (!function_exists('encrypt_userdata')) {
    function encrypt_userdata(string $data)
    {
        try {
            $encryptData = Crypt::encryptString($data);

            return $encryptData;
        } catch (\Exception $e) {
            abort('403');
        }
    }
}
if (!function_exists('decrypt_userdata')) {
    function decrypt_userdata(string $data)
    {
        try {
            $decryptData = Crypt::decryptString($data);

            return $decryptData;
        } catch (\Exception $e) {
            abort('403');
        }
    }
}
