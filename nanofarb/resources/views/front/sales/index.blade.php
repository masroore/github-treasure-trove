@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => trans('site.Акции')]);
        $localeboundAlternativeSegmentUrl = 'sales';
@endphp

@section('content')
    <div class="news">
        <div class="breadcrumb-repeat">
            <ol class="breadcrumb">
                {!! Breadcrumbs::render('sale.index') !!}
            </ol>
        </div>
        <div class="news__wrapper">
            <h1 class="about-title name-big">
                {{ trans('site.Акции') }}
            </h1>

            @forelse($sales as $node)
                <div class="news-block">
                    <div class="news-all">
                        <div class="news-title">
                            <a href="{{ route_alias('news.show', $node) }}">{{ $node->name }}</a>
                        </div>
                        <div class="news-date">
                            {{ $node->created_at->format('d.m.Y') }}
                        </div>
                    </div>
                    <div class="news-text">
                        {!! str_limit($node->description) !!}
                    </div>
                </div>
            @empty
                <p>{{ trans('site.Действующих акций пока нет') }} :(</p>
            @endforelse

            <div class="product-right__navigate">
                <div class="product-right__navigate-button">
                </div>
                <div class="product-right__navigate-pagination pagination-links">
                    {!! $sales->links() !!}
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
