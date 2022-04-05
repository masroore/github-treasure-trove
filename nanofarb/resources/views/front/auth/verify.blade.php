@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => 'Подтверждение Email']);
@endphp

@section('content')
    <div class="register">
        <div class="register__wrapper">
            <div class="register__form">
                <h1 class="register__name">{{ trans('site.Подтверждение вашего Email') }}</h1>
                <br>
                <div class="register__form">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ trans('site.На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.') }}
                        </div>
                    @endif

                    <p>{{ trans('site.Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения вашего Email.') }}</p>

                    <p>{{ trans('site.Если вы не получили письмо,') }} <a href="{{ route('verification.resend', ['locale' => \UrlAliasLocalization::getCurrentLocale()]) }}">{{ trans('site.нажмите здесь, чтобы запросить снова') }}</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
