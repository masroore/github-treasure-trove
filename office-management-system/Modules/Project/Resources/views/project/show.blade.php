@extends('layouts.app_vue', ['title' => $model->name])

@push('css_before')


@endpush

@section('header_content')

<project-header project_id="{{ $model->id }}" blade="{{ $blade }}"></project-header>
@endsection

@section('content')

<project-sections project_id="{{ $model->id }}"></project-sections>

@endsection



@push('js_before')
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/plugin.js') }}"></script>
@endpush

