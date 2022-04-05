@extends('front.layouts.app')

@php
    MetaTag::setEntity($node)->setDefault(['title' => $node->name]);
    $localebound = $node->getLocaleboundStr();
@endphp

@section('content')
    <div class="news">
        <div class="breadcrumb-repeat">
            <ol class="breadcrumb">
                {!! Breadcrumbs::render('news.show', $node) !!}
            </ol>
        </div>
        <div class="news__wrapper">
            <h1 class="about-title name-big">
                {{ $node->name }}
            </h1>

            <div class="news-block">
                <div class="news-all">
                    {{--<div class="news-title">--}}
                        {{--<a href="#">{{ $node->name }}</a>--}}
                    {{--</div>--}}
                    <div class="news-date">
                        {{ $node->created_at->format('d.m.Y') }}
                    </div>
                </div>
                <div class="news-text typography">
                    {!! $node->body !!}
                </div>
            </div>

            @if(MetaTag::tag('seo_text'))
                <div class="about-bottom">
                    <div class="products__info">
                        {!! MetaTag::tag('seo_text') !!}
                        <button class="products__info-btn">
                            <span>Показать полностью</span>
                            <span>Скрыть</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
