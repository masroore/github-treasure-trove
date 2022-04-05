@extends('emails.layouts')

{{--После регистрации на сайте--}}

@section('content')

    <h2>Здравствуйте!</h2>

    <p>Спасибо, что зарегистрировались на нашем сайте.</p>

    @isset($verificationUrl)
        <p>Осталось активировать ваш аккаунт.</p>
        <p>Для этого перейдите по ссылке внизу:</p>
        <p>{{ link_to($verificationUrl) }}</p>
    @endisset

    <p><i>Если у вас возникли вопросы, то пишите нам на почту {{ variable('company_email') }}</i></p>
    <br>
    <p align="center">&copy; {{ date('Y') }} {{ link_to(config('app.url'), config('app.name')) }}</p>
@stop