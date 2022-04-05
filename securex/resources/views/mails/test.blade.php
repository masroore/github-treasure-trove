@component('mail::message')
{!! Lang::get('mails.test.msg_line1') !!}
<br><br> 
{!! Lang::get('mails.regards') !!}  
<br>{!! Lang::get('mails.team', ['app' => Setting::get('app_name')]) !!}
@endcomponent