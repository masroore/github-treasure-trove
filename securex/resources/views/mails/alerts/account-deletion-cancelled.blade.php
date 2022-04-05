@component('mail::message')

{!! Lang::get('mails.alert.account.cancel_deletion.msg_line1', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.cancel_deletion.msg_line2', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.cancel_deletion.msg_line3', ['time' => \Carbon\Carbon::Now()->format('d-M-Y | H:i:s')]) !!}
<br><br>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
