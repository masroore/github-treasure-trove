@extends('admin.app')


@php
    $content_header = [
        'page_title' => 'Формы',
        'url_back' => route('admin.forms.index'),
        'urlCreate' => ''
    ]
@endphp

@section('content')
<section class="content">
    <div class="box">
        {!! Form::model($form, [
            'method' => 'PATCH',
            'route' => ['admin.forms.update', $form],
            'files' => true
        ]) !!}
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Редактирование форму <strong>{{ $form->type }}</strong></h3>
        </div>
        <div class="box-body">
                @include('admin.forms._form')
        </div>
        {!! Form::close() !!}
    </div>
</section>
@stop