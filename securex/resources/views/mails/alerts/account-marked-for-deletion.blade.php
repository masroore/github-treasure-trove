@component('mail::message')

{!! Lang::get('mails.alert.account.marked_deletion.msg_line1', ['app' => Setting::get('app_name'), 'time' => \Carbon\Carbon::parse($user->delete_on)->diffForHumans()]) !!}
<br><br>
{!! Lang::get('mails.alert.account.marked_deletion.msg_line2', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.marked_deletion.msg_line3') !!}
<br><br>
{!! Lang::get('mails.alert.account.marked_deletion.msg_line4', ['time' => \Carbon\Carbon::parse($user->delete_on)->format('d-M-Y | H:i:m')]) !!}
<br><br>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
