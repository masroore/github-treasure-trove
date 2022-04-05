@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Новости',
        'url_back' => route('admin.news.index'),
        'urlCreate' => ''
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-lg-12">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title"> Создание новости</h3>

                    <div class="box-tools pull-right">
                        <ul class="pagination pagination-sm inline">
                            @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $locale)
                                <li class="@if(request('locale', \UrlAliasLocalization::getDefaultLocale()) === $key) active @endif">
                                    @if(!empty($model = \UrlAliasLocalization::getLocaleModelBound($key, request('locale_bound'))))
                                        <a href="{{ route('admin.news.edit', $model) }}" title="{{ $locale['name'] }}">{{ $key }}</a>
                                    @else
                                        <a href="{{ route('admin.news.create', ['locale_bound' => request('locale_bound',\Illuminate\Support\Str::uuid()->toString()), 'locale' => $key,]) }}">{{ $key }}</a>
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
                    @foreach(['Новость' => route('admin.news.create'), 'SEO' => '#'] as $title => $url)
                        <li class="@if(Request::url() == rtrim($url, '/')) active @else disabled @endif"><a @if(Request::url() != rtrim($url, '/')) && $url != '#')href="{{ $url }}"@endif>{{ $title }}</a></li>
                    @endforeach
                    {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <br>
                        {!! Form::open([
                             'route' => 'admin.news.store',
                             'files' => true
                        ]) !!}
                        @include('admin.news._form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@stop
