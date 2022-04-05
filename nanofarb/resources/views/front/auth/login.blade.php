@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => trans('site.Вход на сайт')]);
@endphp

@section('content')
    <div class="personal personal_login">
        <div class="breadcrumb-repeat">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ \UrlAliasLocalization::getRoot() }}">NanoFarb</a>
                </li>
                <li class="breadcrumb-item active">{{ trans('site.Вход') }}</li>
            </ol>
        </div>
        <div class="personal__wrapper">
            <h1 class="name-big">{{ trans('site.Вход') }}</h1>
            <div class="personal__text">
                {{ trans('site.Мы гарантируем конфиденциальность ваших личных данных, предоставленных при регистрации и оформлении заказа') }}
            </div>
            <div class="personal__nav">
                <ul>
                    <li><a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/register">{{ trans('site.Регистрация') }}</a></li>
                    <li class="active"><a href="#">{{ trans('site.Войти') }}</a></li>
                    <li><a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/password/reset/">{{ trans('site.Забыли пароль?') }}</a></li>
                </ul>
            </div>
            <form method="POST" action="{{ route('login') }}" class="js-ajax-form-submit">
                @csrf
                <input type="hidden" name="locale" value="{{ \UrlAliasLocalization::getCurrentLocale() }}">

                <div class="personal-content">
                    <div class="personal-content__left">
                        <div class="personal-content__block">
                            <div class="form-group">
                                <label>
                                    {{ trans('site.E-mail') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="text" name="login">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Пароль') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="password" name="password">
                            </div>
                        </div>
                        <div class="personal-content__left-bottom">
                            <button  type="submit" class="btn-gen">{{ trans('site.Войти') }}</button>
                            <a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/password/reset/">{{ trans('site.Забыли пароль?') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
