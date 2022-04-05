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
                    <h3 class="box-title"> Редактирование новостей <strong>{{ $node->name }}</strong></h3>
                    @include('admin.inc.entity-navigation', [
                       'next' => $node->previous() ? route('admin.news.edit', $node->previous()) : '',
                       'current' => route('news.show', $node),
                       'previous' => $node->next() ? route('admin.news.edit', $node->next()) : '',
                    ])

                    <div class="box-tools pull-right">
                        <ul class="pagination pagination-sm inline">
                            @foreach(\UrlAliasLocalization::getSupportedLocales() as $key => $locale)
                                <li class="@if(isset($node) && $node->locale === $key) active @endif">
                                    @if(!empty($model = \UrlAliasLocalization::getLocaleModelBound($key, $node->getLocaleboundStr())))
                                        <a href="{{ route('admin.news.edit', $model) }}" title="{{ $locale['name'] }}">{{ $key }}</a>
                                    @elseif($node->getLocaleboundStr())
                                        <a href="{{ route('admin.news.create', ['locale_bound' => $node->getLocaleboundStr(), 'locale' => $key,]) }}">{{ $key }}</a>
                                    @else
                                        <a href="{{ route('admin.news.create', ['locale_bound' => \Illuminate\Support\Str::uuid()->toString(), 'locale' => $key,]) }}">{{ $key }}</a>
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
                    @foreach(['Новость' => route('admin.news.edit', $node), 'SEO' => route('admin.news.seo', $node)] as $title => $path)
                        <li class="@if(Request::url() == rtrim($path, '/')) active @endif"><a href="@if(Request::url() !== rtrim($path, '/')){{ $path }}@else # @endif">{{ $title }}</a></li>
                    @endforeach
                    {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <br>
                        @php($tab = isset($tab) ? $tab : request('tab'))
                        @if($tab == 'seo')
                            {!! Form::model($node->metaTag, [
                                'method' => 'POST',
                                'route' => ['admin.news.seo.save', $node],
                                'files' => true,
                            ]) !!}
                            @include('admin.news._seo', ['model' => $node])
                        @else
                            {!! Form::model($node, [
                                'method' => 'PATCH',
                                'route' => ['admin.news.update', $node],
                                'files' => true
                            ]) !!}
                            @include('admin.news._form')
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div><!--/tabs-->
        </div>

    </div>
</section>
@stop