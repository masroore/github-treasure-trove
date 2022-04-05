@component('mail::message')
<b>@lang('auth-logger::messages.hello')!</b>
<br><br>
{{ Lang::get('auth-logger::messages.content', ['app' => config('app.name')]) }}
<br><br>
<b>@lang('auth-logger::messages.account'):</b> {{ $account->email }}<br>
<b>@lang('auth-logger::messages.time'):</b> {{ $time->toCookieString() }}<br>
<b>@lang('auth-logger::messages.ip_address'):</b> {{ $ipAddress }}<br>
<b>@lang('auth-logger::messages.browser'):</b> {{ $browser }} ({{ $browserVersion }})<br>
<b>@lang('auth-logger::messages.platform'):</b> {{ $platform }} ({{ $platformVersion }})  
<br><br>
@lang('auth-logger::messages.ignore')
<br><br>
@lang('auth-logger::messages.regards'),<br>{{ config('app.name') }}
@endcomponent