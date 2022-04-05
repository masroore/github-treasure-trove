@extends('layouts.admin')

@section('title')
{{ __('nav.admin.dashboard') }}
@endsection

@section('content')
@include('admin.dashboard.partials.add-announcement')
@include('admin.dashboard.partials.delete-announcement')
<section class="section">
    <div class="section-header">
        <h1>{{ __('nav.admin.dashboard') }}</h1>
    </div>

    @include('admin.dashboard.partials.stats')
    {!! laraflash()->render() !!}
    @include('admin.dashboard.partials.announcements')
</section>
@endsection