@component('mail::message')
{!! Lang::get('mails.alert.account.deleted.msg_line1', ['app' => Setting::get('app_name'), 'time' => \Carbon\Carbon::parse(Now())->format('d-M-Y | H:i:s')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.deleted.msg_line2') !!}
<br><br>
{!! Lang::get('mails.alert.account.deleted.msg_line3', ['app_email' => Setting::get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
