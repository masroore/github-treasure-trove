@component('mail::message')

{!! Lang::get('mails.alert.account.enabled_two_step.msg_line1', ['app' => Setting::get('app_name'), 'time' => \Carbon\Carbon::parse(Now())->format('d-M-Y | H:i:m')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.enabled_two_step.msg_line2', ['email' => Setting()->get('app_email')]) !!}
<br/><br/>
{!! Lang::get('mails.alert.account.enabled_two_step.msg_line3') !!}
<br/><br/>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
