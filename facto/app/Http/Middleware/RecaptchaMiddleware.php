<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class RecaptchaMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->getHost() == '127.0.0.1' || Str::endsWith($request->getHost(), ['.test'])) {
            return $next($request);
        }
        $url = url()->full();
        $path = parse_url($url, PHP_URL_PATH);

        if (!$path) {
            return $next($request);
        }

        if (get_cf_ip_country() != 'KR') {
            if ($this->isTimeToCheck()) {
                session(['checkRobotReferer' => $url]);

                return redirect()->route('recaptcha-view');
            }
        }

        return $next($request);
    }

    public function isTimeToCheck()
    {
        $session_key = 'counter0099';
        $time_key = 'timer0099';
        $value = session($session_key);
        $interval = 60 * 60 * 2;
        // $interval = 20 ;
        $isTimeToCheck = false;
        if ($value) {
            $value = (int) $value;
            $saved_time = \Carbon\Carbon::parse(session($time_key));
            $diff = \Carbon\Carbon::now()->diffInSeconds($saved_time);
            if ($diff > $interval) {
                $isTimeToCheck = true;
            }
        } else {
            $isTimeToCheck = true;
        }

        return $isTimeToCheck;
    }
}
