@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Товары',
        'small_page_title' => '',
        'url_back' => session('admin.products.index'),
        'url_create' => '',
    ]
@endphp

@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-lg-12">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title"> Редактировать товар <strong>{{ $product->name }}</strong></h3>
                        @include('admin.inc.entity-navigation', [
                            'next' => $product->previous() ? route('admin.products.edit', $product->previous()) : '',
                            'current' => route('product.show', $product),
                            'previous' => $product->next() ? route('admin.products.edit', $product->next()) : '',
                        ])


                        <div class="box-tools pull-right">
                            <ul class="pagination pagination-sm inline">
                                @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $locale)
                                    <li class="@if(isset($product) && $product->locale === $key) active @endif">
                                        @if(!empty($model = \UrlAliasLocalization::getLocaleModelBound($key, $product->getLocaleboundStr())))
                                            <a href="{{ route('admin.products.edit', $model) }}" title="{{ $locale['name'] }}">{{ $key }}</a>
                                        @elseif($product->getLocaleboundStr())
                                            <a href="{{ route('admin.products.create', ['locale_bound' => $product->getLocaleboundStr(), 'locale' => $key, 'product_group_id' => $product->product_group_id, 'product_id' => $product->id]) }}">{{ $key }}</a>
                                        @else
                                            <a href="{{ route('admin.products.create', ['locale_bound' => \Illuminate\Support\Str::uuid()->toString(), 'locale' => $key, 'product_group_id' => $product->product_group_id]) }}">{{ $key }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                    </div>
                </div>
            </div>
            <div class="box-body">
                <!--tabs-->
                <div class="nav-tabs-justified">
                    <ul class="nav nav-tabs">
                        @foreach(['Товар' => route('admin.products.edit', $product), 'Значения атрибутов' => route('admin.products.values', $product), 'SEO' => route('admin.products.seo', $product)] as $title => $path)
                            <li class="@if(Request::url() == rtrim($path, '/')) active @endif"><a href="@if(Request::url() !== rtrim($path, '/')){{ $path }}@else # @endif">{{ $title }}</a></li>
                        @endforeach
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <br>
                            @php($tab = isset($tab) ? $tab : request('tab'))
                            @if($tab == 'values')
                                {!! Form::model($product, [
                                    'method' => 'POST',
                                    'route' => ['admin.products.values.save', $product],
                                ]) !!}
                                @include('admin.shop.products._values')
                            @elseif($tab == 'seo')
                                {!! Form::model($product->metaTag, [
                                    'method' => 'POST',
                                    'route' => ['admin.products.seo.save', $product],
                                    'files' => true,
                                ]) !!}
                                @include('admin.shop.products._seo', ['model' => $product])
                            @else
                                {!! Form::model($product, [
                                    'method' => 'PATCH',
                                    'route' => ['admin.products.update', $product->id],
                                    'files' => true
                                ]) !!}
                                @include('admin.shop.products._form')
                            @endif
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div><!--/tabs-->
            </div>
        </div>
    </section>
@stop