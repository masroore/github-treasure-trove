@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => '403 - '.trans('site.Доступ запрещен')]);
@endphp

@section('content')
    <div class="page-error">
        <div class="page-error__wrapper">
            <div class="page-error__img">
                <img src="/its-client/img/404.png" alt="">
            </div>
            <div class="page-error__block">
                <div class="page-error__title">
                    403
                </div>
                <div class="page-error__button">
                    <a href="/" class="btn-gen">{{ trans('site.Вернуться на главную') }}</a>
                </div>
                {{--{{ $exception->getMessage() }}--}}
                {{--<div class="error-page__text">{!! (app()->isLocal() && isset($exception) && ($exception->getMessage()) ? $exception->getMessage() : '') !!}</div>--}}
            </div>
        </div>
    </div>
@endsection
