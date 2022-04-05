@component('mail::message')

{!! Lang::get('mails.alert.account.banned.msg_line1', ['app' => Setting::get('app_name'), 'remark' => $user->remark, 'time' => \Carbon\Carbon::parse($user->remark_date)->format('d-M-Y | H:i:s')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.banned.msg_line2', ['email' => Setting::get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.banned.msg_line3') !!}
<br><br>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
