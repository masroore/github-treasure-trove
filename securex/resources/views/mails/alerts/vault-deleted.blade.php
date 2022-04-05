@component('mail::message')

{!! Lang::get('mails.alert.account.vault_deleted.msg_line1', ['vault' => $vault->name, 'time' => \Carbon\Carbon::parse(Now())->format('d-M-Y | H:i:m')]) !!}
<br><br>
{!! Lang::get('mails.alert.account.vault_deleted.msg_line2', ['app' => Setting::get('app_name')]) !!}
<br><br>
{!! Lang::get('mails.automated_email', ['email' => Setting()->get('app_email')]) !!}
<br><br>
{!! Lang::get('mails.regards') !!}
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent
