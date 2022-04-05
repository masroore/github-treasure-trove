@extends('layouts.admin')

@section('title')
{{ __('nav.admin.all_users') }}
@endsection

@section('content')
@include('admin.users.partials.add-user')
<section class="section">
    <div class="section-header">
        <h1>{{ __('nav.admin.all_users') }}</h1>
        <div class="section-header-breadcrumb">
            <button data-toggle="modal" data-target="#add-user" class="btn btn-outline-primary btn-icon"><i class="fas fa-plus"></i> {{ __('admin.users.add') }}</button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            {!! laraflash()->render() !!}
                
            @livewire('admin.users.users-list')
        </div>
    </div>
</section>
@endsection