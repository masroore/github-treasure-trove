@extends('emails.layouts')

{{-- После подтверждение (оформления) заказа --}}

@section('content')
    <h2>Подтвердить Email</h2>

    Для подтверждения вашего Email перейдите по ссылке: {{ $verificationUrl }}
    <br>

    <p align="center">&copy; {{ date('Y') }} {{ link_to(config('app.url'), config('app.name')) }}</p>
@stop