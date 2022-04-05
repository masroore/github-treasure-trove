@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Пользователи',
        'url_back' => session('admin.users.index'),
        'urlCreate' => ''
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        {!! Form::open([
             'route' => 'admin.users.store',
             'files' => true
        ]) !!}
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Создание пользователя</h3>
        </div>
        <div class="box-body">
            @include('admin.users._form')
        </div>
        {!! Form::close() !!}
    </div>
</section>
@stop
