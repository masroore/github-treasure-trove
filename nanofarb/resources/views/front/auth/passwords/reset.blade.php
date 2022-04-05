@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => 'Восстановление пароля']);
@endphp

@section('content')
    <div class="personal personal_password personal_login">
        <div class="breadcrumb-repeat">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ \UrlAliasLocalization::getRoot() }}">NanoFarb</a>
                </li>
                <li class="breadcrumb-item active">{{ trans('site.Установка нового пароля') }}</li>
            </ol>
        </div>
        <div class="personal__wrapper">
            <h1 class="name-big">{{ trans('site.Установка нового пароля') }}</h1>
            <div class="personal__text">
                {{ trans('site.Мы гарантируем конфиденциальность ваших личных данных, предоставленных при регистрации и оформлении заказа') }}
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="personal__nav">
                <ul>
                    <li><a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/register">{{ trans('site.Регистрация') }}</a></li>
                    <li><a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/login">{{ trans('site.Войти') }}</a></li>
                    <li class="active"><a href="#">{{ trans('site.Забыли пароль?') }}</a></li>
                </ul>
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="personal-content">
                    <div class="personal-content__left">
                        <div class="personal-content__block">
                            <div class="form-group {{ $errors->has('email') ? 'error' : ''}}">
                                <label>
                                    {{ trans('site.E-mail') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="text" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                                {!! $errors->first('email', '<p class="text-error">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'error' : ''}}">
                                <label>
                                    {{ trans('site.Пароль') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="password" name="password" required>
                                {!! $errors->first('password', '<p class="text-error">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'error' : ''}}">
                                <label>
                                    {{ trans('site.Подтвердите пароль') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="password" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="personal-content__left-bottom">
                            <button type="submit" class="btn-gen">{{ trans('site.Сохранить новый пароль') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
