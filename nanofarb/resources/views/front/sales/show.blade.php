@extends('front.layouts.app')

@php
    MetaTag::setEntity($sale)->setDefault(['title' => $sale->name]);
    $localebound = $sale->getLocaleboundStr();
@endphp

@section('content')
    <div class="news">
        <div class="breadcrumb-repeat">
            <ol class="breadcrumb">
                {!! Breadcrumbs::render('sale.show', $sale) !!}
            </ol>
        </div>
        <div class="news__wrapper">
            <h1 class="about-title name-big">
                {{ $sale->name }}
            </h1>

            <div class="news-block">
                <div class="news-all">
                    {{--<div class="news-title">--}}
                    {{--<a href="#">{{ $sale->name }}</a>--}}
                    {{--</div>--}}
                    <div class="news-date">
                        {{ $sale->created_at->format('d.m.Y') }}
                    </div>
                </div>
                <div class="news-text typography">
                    {!! $sale->description !!}
                </div>
            </div>

            @if(MetaTag::tag('seo_text'))
                <div class="about-bottom">
                    <div class="products__info">
                        {!! MetaTag::tag('seo_text') !!}
                        <button class="products__info-btn">
                            <span>{{ trans('site.Показать полностью') }}</span>
                            <span>{{ trans('site.Скрыть') }}</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection