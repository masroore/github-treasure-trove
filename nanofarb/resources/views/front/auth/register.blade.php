@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => trans('site.Регистрация на сайте')]);
@endphp

@section('content')
    <div class="personal">
        <div class="breadcrumb-repeat">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ \UrlAliasLocalization::getRoot() }}">NanoFarb</a>
                </li>
                <li class="breadcrumb-item active">{{ trans('site.Регистрация пользователя') }}</li>
            </ol>
        </div>
        <div class="personal__wrapper">
            <h1 class="name-big">{{ trans('site.Регистрация пользователя') }}</h1>
            <div class="personal__text">
                {{ trans('site.Мы гарантируем конфиденциальность ваших личных данных, предоставленных при регистрации и оформлении заказа') }}
            </div>
            <div class="personal__nav">
                <ul>
                    <li class="active"><a href="#">{{ trans('site.Регистрация') }}</a></li>
                    <li><a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/login">{{ trans('site.Войти') }}</a></li>
                    <li><a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/password/reset/">{{ trans('site.Забыли пароль?') }}</a></li>
                </ul>
            </div>
            <form action="{{ route('register') }}" method="POST" class="js-ajax-form-submit">
                <input type="hidden" name="locale" value="{{ \UrlAliasLocalization::getCurrentLocale() }}">

                <div class="personal-content">
                    <div class="personal-content__block">
                        <div class="form-group">
                            <label>
                                {{ trans('site.Имя') }}
                                <span>*</span>
                            </label>
                            <input class="input" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('site.Фамилия') }}
                            </label>
                            <input class="input" type="text" name="last_name">
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('site.E-mail') }}
                                <span>*</span>
                            </label>
                            <input class="input" type="email" name="email">
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('site.Телефон') }}
                                <span>*</span>
                            </label>
                            <input class="input phone" type="text" name="phone" placeholder="{{ config('web-forms.phone.placeholder') }}" data-mask="{{ config('web-forms.phone.mask') }}" data-mask-clearifnotmatch="true">
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('site.Пароль') }}
                                <span>*</span>
                            </label>
                            <input class="input" type="password" name="password">
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('site.Повторить пароль') }}
                                <span>*</span>
                            </label>
                            <input class="input" type="password" name="password_confirmation">
                        </div>
                    </div>
                    <div class="personal-content__right">
                        <div class="personal-content__block">
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Ваш пол') }}
                                    <span>*</span>
                                </label>
                                <select class="select-filter" id="select2-filter" name="data[gender]">
                                    <option></option>
                                    <option value="male" data-img="icon-arrow-top">{{ trans('site.Мужчина') }}</option>
                                    <option value="female" data-img="icon-arrow-top">{{ trans('site.Женщина') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.День рождения') }}
                                </label>
                                <input id="birthday" class="input" type="text" name="birthday">
                            </div>
                        </div>
                        <div class="personal-content__right-bottom">
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <label>
                                        <input type="hidden" name="data[subscribe]" value="0">
                                        <input class="checkbox" type="checkbox" name="data[subscribe]" value="1">
                                        <span class="checkbox-custom"></span>
                                        <span class="label">{{ trans('site.Я согласен получать редкие рассылки о спецпредложениях') }} </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox-group">
                                    <label>
                                        <input type="hidden" name="accept" value="0">
                                        <input class="checkbox" type="checkbox" name="accept" value="1">
                                        <span class="checkbox-custom"></span>
                                        <span class="label">{{ trans('site.Я согласен(-на) с')}} <a href="/{{ \UrlAliasLocalization::getCurrentLocale() }}/policy/">{{ trans('site.условиями регистрации') }}*</a></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-button">
                                <button type="submit" class="btn-gen">{{ trans('site.Регистрация') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
