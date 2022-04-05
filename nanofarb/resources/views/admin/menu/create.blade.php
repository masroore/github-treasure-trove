@extends('admin.app')

@php
    $content_header = [
        'page_title' => $menu->name,
        'small_page_title' => '',
        'url_back' => route('admin.menu-items.index', ['menu_id' => $menu->id]),
        'url_create' => '',
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        {!! Form::open([
             'route' => 'admin.menu-items.store',
             'files' => true
        ]) !!}
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Создание пункта меню для меню <strong>{{ $menu->name }}</strong></h3>
        </div>
        <div class="box-body">
            @include('admin.menu._form')
        </div>
        {!! Form::close() !!}
    </div>
</section>
@stop
