@extends('front.layouts.app', [
    // for on scroll pagination
    "bodyAttrs" => "data-next-page-url={$products->nextPageUrl()}
                    data-content-container='.show-more-content-container'
                    data-show-more-loader='.show-more-loader'
                    "
                    //class='show-more-scroll-container'
])

@php
    MetaTag::setDefault(['title' => trans('site.Результаты поиска') . " - {$products->total()} товаров"]);
    FacetFilter::setUrlPath(\UrlAlias::current());
@endphp

@section('content')
    <div class="product product_search">
        <div class="breadcrumb-repeat">
            {!! Breadcrumbs::render('home', trans('site.Поиск')) !!}
        </div>
        <div class="product__wrapper">

            <div class="product-right">
                <div class="product-right__head">
                    <div class="product-right__head-left">
                        <h1 class="name-big">{{ trans('site.Результаты поиска') }}</h1>
                    </div>
                </div>

                <div class="product-right__content show-more-content-container">
                    @if($products->count())
                        @include('front.products.inc.grid-products', ['products' => $products])
                    @else
                        <p>{{ trans('site.Поиск не дал результатов') }} :(</p>
                    @endif
                </div>

                <div class="product-right__navigate">
                    @if($products->nextPageUrl())
                    <div class="product-right__navigate-button">
                        <button class="btn-gen show-more-btn"
                                data-next-page-url="{{ $products->appends(request()->except('page'))->nextPageUrl() }}"
                                data-content-container=".show-more-content-container"
                        >{{ trans('site.Показать больше') }}</button>
                    </div>
                    @endif


                    <div class="product-right__navigate-pagination">
                        {!! $products->appends(request()->all())->links() !!}
                    </div>
                </div>

                @if(MetaTag::tag('seo_text'))
                <div class="product-right__bottom">
                    <div class="products__info">
                        <p>{!! MetaTag::tag('seo_text') !!}</p>
                        <button class="products__info-btn">
                            <span>{{ trans('site.Показать полностью') }}</span>
                            <span>{{ trans('site.Скрыть') }}</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection