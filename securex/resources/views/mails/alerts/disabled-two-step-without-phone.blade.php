@component('mail::message')

{!! Lang::get('mails.alert.account.disabled_two_step.msg_line1_wp', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.disabled_two_step.msg_line2', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.disabled_two_step.msg_line3', ['time' => \Carbon\Carbon::parse(Now())->format('d-M-Y | H:i:m')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.disabled_two_step.msg_line4', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
