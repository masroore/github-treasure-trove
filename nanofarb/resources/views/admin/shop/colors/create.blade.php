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
                        <h3 class="box-title"> Создание товара</h3>

                        <div class="box-tools pull-right">
                            <ul class="pagination pagination-sm inline">
                                @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $locale)
                                    <li class="@if(request('locale', \UrlAliasLocalization::getDefaultLocale()) === $key) active @endif">
                                        @if(!empty($model = \UrlAliasLocalization::getLocaleModelBound($key, request('locale_bound'))))
                                            <a href="{{ route('admin.products.edit', $model) }}" title="{{ $locale['name'] }}">{{ $key }}</a>
                                        @else
                                            <a href="{{ route('admin.products.create', ['locale_bound' => request('locale_bound',\Illuminate\Support\Str::uuid()->toString()), 'locale' => $key, 'product_group_id' => request('product_group_id')]) }}">{{ $key }}</a>
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
                        @foreach(['Товар' => route('admin.products.create'), 'Значения атрибутов' => '#', 'SEO' => '#'] as $title => $url)
                            <li class="@if(Request::url() == rtrim($url, '/')) active @else disabled @endif"><a @if(Request::url() != rtrim($url, '/')) && $url != '#')href="{{ $url }}"@endif>{{ $title }}</a></li>
                        @endforeach
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <br>
                            {!! Form::open([
                                 'route' => 'admin.products.store',
                                 'files' => true
                            ]) !!}
                            @include('admin.shop.products._form')
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
