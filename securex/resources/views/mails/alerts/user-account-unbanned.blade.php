@component('mail::message')

{!! Lang::get('mails.alert.account.unbanned.msg_line1', ['app' => Setting::get('app_name'), 'time' => \Carbon\Carbon::parse(Now())->format('d-M-Y | H:i:s')]) !!}
<br><br>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
