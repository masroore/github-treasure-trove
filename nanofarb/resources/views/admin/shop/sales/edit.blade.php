@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Акции',
        'small_page_title' => '',
        'url_back' => session('admin.sales.index'),
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
                        <h3 class="box-title"> Редактировать акцию <strong>{{ $sale->name }}</strong></h3>
                        @include('admin.inc.entity-navigation', [
                            'next' => $sale->previous() ? route('admin.sales.edit', $sale->previous()) : '',
                            'current' => route('sale.show', $sale),
                            'previous' => $sale->next() ? route('admin.sales.edit', $sale->next()) : '',
                        ])

                        <div class="box-tools pull-right">
                            <ul class="pagination pagination-sm inline">
                                @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $locale)
                                    <li class="@if(isset($sale) && $sale->locale === $key) active @endif">
                                        @if(!empty($model = \UrlAliasLocalization::getLocaleModelBound($key, $sale->getLocaleboundStr())))
                                            <a href="{{ route('admin.sales.edit', $model) }}" title="{{ $locale['name'] }}">{{ $key }}</a>
                                        @elseif($sale->getLocaleboundStr())
                                            <a href="{{ route('admin.sales.create', ['locale_bound' => $sale->getLocaleboundStr(), 'locale' => $key,]) }}">{{ $key }}</a>
                                        @else
                                            <a href="{{ route('admin.sales.create', ['locale_bound' => \Illuminate\Support\Str::uuid()->toString(), 'locale' => $key,]) }}">{{ $key }}</a>
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
                        @foreach(['Акция' => route('admin.sales.edit', $sale), 'Опции' => route('admin.sales.options', $sale), 'SEO' => route('admin.sales.seo', $sale)] as $title => $url)
                            <li class="@if(Request::url() == rtrim($url, '/')) active @endif"><a href="@if(Request::fullUrl() !== rtrim($url, '/')){{ $url }}@else # @endif">{{ $title }}</a></li>
                        @endforeach
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <br>
                            @php($tab = isset($tab) ? $tab : request('tab'))
                            @if($tab == 'options')
                                {!! Form::model($sale, [
                                    'method' => 'POST',
                                    'route' => ['admin.sales.options.save', $sale],
                                ]) !!}
                                @include('admin.shop.sales._options')
                            @elseif($tab == 'seo')
                                {!! Form::model($sale->metaTag, [
                                    'method' => 'POST',
                                    'route' => ['admin.sales.seo.save', $sale],
                                    'files' => true,
                                ]) !!}
                                @include('admin.shop.sales._seo', ['model' => $sale])
                            @else
                                {!! Form::model($sale, [
                                    'method' => 'PATCH',
                                    'route' => ['admin.sales.update', $sale->id],
                                    'files' => true
                                ]) !!}
                                @include('admin.shop.sales._form')
                            @endif
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div><!--/tabs-->
            </div>
        </div>
    </section>
@stop