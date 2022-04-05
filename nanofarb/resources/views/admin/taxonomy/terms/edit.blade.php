@extends('admin.app')

@php
    $content_header = [
        'page_title' => $vocabulary->name,
        'url_back' => session('admin.terms.index'),
        'url_create' => ''
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Редактирование термина <strong>{{ $term->name }}</strong> словаря <strong>{{ $vocabulary->name }}</strong></h3>

            <div class="box-tools pull-right">
                <ul class="pagination pagination-sm inline">
                    @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $locale)
                    <li class="@if(isset($term) && $term->locale === $key) active @endif">
                        @if(!empty($model = \UrlAliasLocalization::getLocaleModelBound($key, $term->getLocaleboundStr())))
                            <a href="{{ route('admin.terms.edit', $model) }}" title="{{ $locale['name'] }}">{{ $key }}</a>
                        @elseif($term->getLocaleboundStr())
                            <a href="{{ route('admin.terms.create', ['locale_bound' => $term->getLocaleboundStr(), 'locale' => $key, 'vocabulary' => $term->vocabulary]) }}">{{ $key }}</a>
                        @else
                            <a href="{{ route('admin.terms.create', ['locale_bound' => \Illuminate\Support\Str::uuid()->toString(), 'locale' => $key, 'vocabulary' => $term->vocabulary]) }}">{{ $key }}</a>
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
                    @foreach(['Термин' => route('admin.terms.edit', $term), 'SEO' => route('admin.terms.seo', $term)] as $title => $path)
                        <li class="@if(Request::url() == rtrim($path, '/')) active @endif"><a href="@if(Request::url() !== rtrim($path, '/')){{ $path }}@else # @endif">{{ $title }}</a></li>
                    @endforeach
                    {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <br>
                        @php($tab = isset($tab) ? $tab : request('tab'))
                        @if($tab == 'seo')
                            {!! Form::model($term->metaTag, [
                                'method' => 'POST',
                                'route' => ['admin.terms.seo.save', $term],
                            ]) !!}
                            @include('admin.taxonomy.terms._seo', ['model' => $term])
                        @else
                            {!! Form::model($term, [
                                'method' => 'PATCH',
                                'route' => ['admin.terms.update', $term],
                                'files' => true
                            ]) !!}
                            @include('admin.taxonomy.terms._form')
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div><!--/tabs-->
        </div>
    </div>
</section>
@stop