@extends('admin.app')

@php
    $content_header = [
        'page_title' => $vocabulary->name,
        'url_back' => session('admin.vocabularies.index'),
        'url_create' => ''
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Редактирование словаря <strong>{{ $vocabulary->name }}</strong></h3>
        </div>
        <div class="box-body">
            <!--tabs-->
            <div class="nav-tabs-justified">
                <ul class="nav nav-tabs">
                    @foreach(['Словарь' => route('admin.vocabularies.edit', $vocabulary), 'SEO' => route('admin.terms.seo', $vocabulary)] as $title => $path)
                        <li class="@if(Request::url() == rtrim($path, '/')) active @endif"><a href="@if(Request::url() !== rtrim($path, '/')){{ $path }}@else # @endif">{{ $title }}</a></li>
                    @endforeach
                    {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <br>
                        @php($tab = isset($tab) ? $tab : request('tab'))
                        @if($tab == 'seo')
                            {!! Form::model($vocabulary->metaTag, [
                                'method' => 'POST',
                                'route' => ['admin.vocabularies.seo.save', $vocabulary],
                            ]) !!}
                            @include('admin.taxonomy.vocabularies._seo', ['model' => $vocabulary])
                        @else
                            {!! Form::model($vocabulary, [
                                'method' => 'PATCH',
                                'route' => ['admin.vocabularies.update', $vocabulary],
                                'files' => true
                            ]) !!}
                            @include('admin.taxonomy.vocabularies._form')
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div><!--/tabs-->
        </div>
    </div>
</section>
@stop