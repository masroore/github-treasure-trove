@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => trans('site.Продукция')]);
    $localeboundAlternativeSegmentUrl = '/productions';
@endphp

@section('content')
    <div class="products">
        <div class="products__wrapper">
            <div class="breadcrumb-repeat">
                {!! Breadcrumbs::render('categories') !!}
            </div>

            <div class="home">
                <div class="home__wrapper">
                    <div class="name-big">
                        {{ trans('site.Продукция') }}
                    </div>
                    <div class="home__product">
                        <div class="home__product-info">
                            @foreach($categories as $category)
                                <div class="home__product-block">
                                    <a href="{{ route_alias('category.show', $category) }}">
                                        <img src="{{ $category->getMyFirstMediaUrl('image', 'table', '/its-client/img/home-prod-1.png') }}" alt="{{ $category->name }}">
                                        <div class="name">{{ $category->name }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if(MetaTag::tag('seo_text'))
                    <div class="products__info">
                        <p>{!! MetaTag::tag('seo_text') !!}</p>
                        <button class="products__info-btn">
                            <span>{{ trans('site.Показать полностью') }}</span>
                            <span>{{ trans('site.Скрыть') }}</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
