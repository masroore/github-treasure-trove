@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])

@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ Lang::get('mails.footer_text') }} 
  
{{ Lang::get('mails.mailing_address') }} <br>
**{{ Setting::get('app_company')}}**  
{{ Setting::get('app_address')}}  
{{ Lang::get('mails.email') }} {{ Setting::get('app_email') }}  
{{ Lang::get('mails.phone') }} {{ Setting::get('app_phone')}}
@endcomponent
@endslot
@endcomponent