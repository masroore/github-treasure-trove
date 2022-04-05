<?php

namespace Modules\UserActivityLog\Traits;

use Browser;
use Carbon\Carbon;
use Modules\UserActivityLog\Entities\LogActivity as LogActivityModel;
use Request;

class LogActivity
{
    public static function addLog($type, $subject): void
    {
        $log = [];
        $log['type'] = $type;
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Browser::browserFamily() . '-' . Browser::browserVersion() . '-' . Browser::browserEngine() . '-' . Browser::platformName() . '-' . Browser::deviceModel();
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        LogActivityModel::create($log);
    }

    public static function errorLog($message): void
    {
        $type = 0;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function loginLog($message): void
    {
        $type = 1;
        $subject = $message;
        self::addLoginLog($type, $subject);
    }

    public static function logoutLog($user_id, $message): void
    {
        $subject = $message;
        self::addLogoutLog($user_id, $subject);
    }

    public static function successLog($message): void
    {
        $type = 1;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function warningLog($message): void
    {
        $type = 2;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function infoLog($message): void
    {
        $type = 3;
        $subject = $message;
        self::addLog($type, $subject);
    }

    public static function logActivityLists()
    {
        return LogActivityModel::with('user')->where('login', 0)->latest()->get();
    }

    public static function logActivityListsDuty()
    {
        return LogActivityModel::with('user')->where('login', 1)->latest()->get();
    }

    public static function addLoginLog($type, $subject): void
    {
        $log = [];
        $log['type'] = $type;
        $log['login'] = 1;
        $log['login_time'] = Carbon::now();
        $log['logout_time'] = null;
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Browser::browserFamily() . '-' . Browser::browserVersion() . '-' . Browser::browserEngine() . '-' . Browser::platformName() . '-' . Browser::deviceModel();
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        LogActivityModel::create($log);
    }

    public static function addLogoutLog($user_id, $subject): void
    {
        $loginActivity = LogActivityModel::where('login', 1)->where('logout_time', null)->where('user_id', $user_id)->where('ip', Request::ip())->where('agent', Browser::browserFamily() . '-' . Browser::browserVersion() . '-' . Browser::browserEngine() . '-' . Browser::platformName() . '-' . Browser::deviceModel())->first();
        if ($loginActivity) {
            $loginActivity->logout_time = Carbon::now();
            $loginActivity->subject = $subject;
            $loginActivity->save();
        }
    }
}
