@component('mail::message')

{!! Lang::get('mails.alert.account.site_limit.msg_line1', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.site_limit.msg_line2') !!}
<br><br>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
