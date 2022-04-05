@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Внешнии площадки',
        'url_back' => '',
        'url_create' => '',
    ]
@endphp

@section('content')
    <section class="content">
        @include('externalshop::variables.form')
    </section>
@endsection
