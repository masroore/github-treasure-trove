@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Мета-теги',
        'url_back' => session('admin.meta-tags.index'),
        'urlCreate' => ''
    ]
@endphp

@section('content')
    <section class="content">
        <div class="box">
            {!! Form::model($metaTag, [
                'method' => 'PATCH',
                'route' => ['admin.meta-tags.update', $metaTag],
                'files' => true
            ]) !!}
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Редактирование мета-тегов</h3>
            </div>
            <div class="box-body">
                @include('admin.seo.meta-tags._form')
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop