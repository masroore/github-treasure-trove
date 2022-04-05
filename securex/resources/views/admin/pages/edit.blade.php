@extends('layouts.admin')

@section('title')
{{ __('admin.pages.edit') }}
@endsection

@section('css')
<link href="{{ asset('assets/vendor/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
    .note-editor .note-dropzone { opacity: 0 !important; }
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('nav.admin.pages') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.pages.index') }}">{{ __('nav.admin.pages') }}</a></div>
            <div class="breadcrumb-item">{{ __('admin.pages.edit') }}</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ __('admin.pages.edit') }}</h2>
        <p class="section-lead">
            {{ __('admin.pages.edit_sub') }}
        </p>

        <div class="row">
            <div class="col-12">
                {!! laraflash()->render() !!}
                <div class="card">
                    <!-- Edit Page Form Livewired -->
                    @livewire('admin.pages.edit', ['page' => $page])
                </div>
            </div>
        </div>
    </div>
</section>
@endsection