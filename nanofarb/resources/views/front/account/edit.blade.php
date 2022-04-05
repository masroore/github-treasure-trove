@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => trans('site.Личные данные')]);
    $localeboundAlternativeSegmentUrl = 'account';
@endphp

@section('content')
    <div class="personal personal_user">
        <div class="breadcrumb-repeat">
            {!! Breadcrumbs::render('home', trans('site.Личные данные')) !!}
        </div>
        <div class="personal__wrapper">
            <h1 class="name-big">{{ trans('site.Личный кабинет') }}</h1>
            <div class="personal__text">
                {{ trans('site.Здесь вы можете изменить ваши персональные данные') }}
            </div>
            <div class="personal__nav">
                <ul>
                    <li class="active"><a href="#">{{ trans('site.Личные данные') }}</a></li>
                    <li><a href="{{ route_alias('account.history') }}">{{ trans('site.История заказов') }}</a></li>
                </ul>
            </div>
            <form action="{{ route('account.update') }}" method="POST" class="js-ajax-form-submit" data-id="account-update">
                <div class="personal-content">
                    <div class="personal-content__left">
                        <div class="user-name">{{ trans('site.Персональные данные') }}</div>
                        <div class="personal-content__block">
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Имя') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="text" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Фамилия') }}
                                </label>
                                <input class="input" type="text" name="last_name" value="{{ $user->last_name }}">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.E-mail') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="email" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Телефон') }}
                                    <span>*</span>
                                </label>
                                <input class="input phone" type="text" name="phone" value="{{ $user->phone }}" placeholder="{{ config('web-forms.phone.placeholder') }}" data-mask="{{ config('web-forms.phone.mask') }}" data-mask-clearifnotmatch="true">
                            </div>
                        </div>
                    </div>
                    <div class="personal-content__right">
                        <div class="user-name">{{ trans('site.Изменить пароль') }}</div>
                        <div class="personal-content__block">
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Старый пароль') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="password" name="password_current">
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Новый пароль') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="password" name="password" data-validator-options='{"relatedSelectors":["[name=password_confirmation]"]}'>
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('site.Повторить пароль') }}
                                    <span>*</span>
                                </label>
                                <input class="input" type="password" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="personal-content__left-bottom">
                        <div class="form-group">
                            <div class="checkbox-group">
                                <label>
                                    <input type="hidden" name="data[subscribe]" value="0">
                                    <input class="checkbox" type="checkbox" name="data[subscribe]" value="1" @if(!empty($user->data['subscribe'])) checked @endif>
                                    <span class="checkbox-custom"></span>
                                    <span class="label">{{ trans('site.Подписаться на новости и акции') }}</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn-gen">{{ trans('site.Сохранить') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection