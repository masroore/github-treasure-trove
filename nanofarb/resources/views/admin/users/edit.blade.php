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
        {!! Form::model($user, [
            'method' => 'PATCH',
            'route' => ['admin.users.update', $user],
            'files' => true
        ]) !!}
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Редактирование пользователя <strong>{{ $user->name }}</strong></h3>
        </div>
        <div class="box-body">
                @include('admin.users._form')
        </div>
        {!! Form::close() !!}
    </div>
</section>
@stop