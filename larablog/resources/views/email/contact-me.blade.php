@component('mail::message')
# Name
---
{{ $name }}

# Message
---
{{ $message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
