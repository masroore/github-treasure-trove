@extends('admin.app')

@php
    $content_header = [
        'page_title' => $vocabulary->name,
        'url_back' => session('admin.terms.index'),
        'urlCreate' => ''
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">

        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Создание термина словаря <strong>{{ $vocabulary->name }}</strong></h3>

            <div class="box-tools pull-right">
                <ul class="pagination pagination-sm inline">
                    @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $locale)
                        <li class="@if(request('locale', \UrlAliasLocalization::getDefaultLocale()) === $key) active @endif">
                            @if(!empty($model = \UrlAliasLocalization::getLocaleModelBound($key, request('locale_bound'))))
                                <a href="{{ route('admin.terms.edit', $model) }}" title="{{ $locale['name'] }}">{{ $key }}</a>
                            @else
                                <a href="{{ route('admin.terms.create', ['locale_bound' => request('locale_bound',\Illuminate\Support\Str::uuid()->toString()), 'locale' => $key, 'vocabulary' => request('vocabulary')]) }}">{{ $key }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <div class="box-body">

            <!--tabs-->
            <div class="nav-tabs-justified">
                <ul class="nav nav-tabs">
                    @foreach(['Термин' => route('admin.terms.create'), 'SEO' => '#'] as $title => $url)
                        <li class="@if(Request::url() == rtrim($url, '/')) active @else disabled @endif"><a @if(Request::url() != rtrim($url, '/')) && $url != '#')href="{{ $url }}"@endif>{{ $title }}</a></li>
                    @endforeach
                    {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <br>
                        {!! Form::open([
                             'route' => 'admin.terms.store',
                             'files' => true
                        ]) !!}
                        @include('admin.taxonomy.terms._form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div><!--/tabs-->
        </div>
    </div>
</section>
@stop
