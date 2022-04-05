<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use Closure;
use Illuminate\Http\Request;

class Setting
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        config([
            'app.name' => UtilityFacades::getsettings('app_name'),

            'filesystems.default' => (UtilityFacades::getsettings('settingtype') != '') ? UtilityFacades::getsettings('settingtype') : 'local',
            'filesystems.disks.s3.key' => UtilityFacades::getsettings('s3_key'),
            'filesystems.disks.s3.secret' => UtilityFacades::getsettings('s3_secret'),
            'filesystems.disks.s3.region' => UtilityFacades::getsettings('s3_region'),
            'filesystems.disks.s3.bucket' => UtilityFacades::getsettings('s3_bucket'),
            'filesystems.disks.s3.url' => UtilityFacades::getsettings('s3_url'),
            'filesystems.disks.s3.endpoint' => UtilityFacades::getsettings('s3_endpoint'),

            'mail.default' => UtilityFacades::getsettings('mail_mailer'),
            'mail.mailers.smtp.host' => UtilityFacades::getsettings('mail_host'),
            'mail.mailers.smtp.port' => UtilityFacades::getsettings('mail_port'),
            'mail.mailers.smtp.encryption' => UtilityFacades::getsettings('mail_encryption'),
            'mail.mailers.smtp.username' => UtilityFacades::getsettings('mail_username'),
            'mail.mailers.smtp.password' => UtilityFacades::getsettings('mail_password'),
            'mail.from.address' => UtilityFacades::getsettings('mail_from_address'),
            'mail.from.name' => UtilityFacades::getsettings('mail_from_name'),

            'chatify.pusher.key' => UtilityFacades::getsettings('pusher_key'),
            'chatify.pusher.secret' => UtilityFacades::getsettings('pusher_secret'),
            'chatify.pusher.app_id' => UtilityFacades::getsettings('pusher_id'),
            'chatify.pusher.options.cluster' => UtilityFacades::getsettings('pusher_cluster'),
        ]);

        return $next($request);
    }
}
