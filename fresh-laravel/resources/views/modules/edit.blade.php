@extends('layouts.admin')
@section('title', 'Modules')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Role</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('modules.index') }}">Modules</a></div>
                    <div class="breadcrumb-item">Edit Modules</div>
                </div>
            </div>
            {!! Form::model($module, ['method' => 'PATCH', 'route' => ['modules.update', $module->id]]) !!}
            <div class="col-md-4 m-auto">
                <div class="card">
                    <div class="card-header">{{ __('Edit Module') }} </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('name', __('Name')) }}
                            {!! Form::text('name', null, ['placeholder' => __('Name'), 'class' => 'form-control']) !!}
                            {!! Form::hidden('old_name', $module->name, ['placeholder' => __('Name'), 'class' => 'form-control']) !!}
                        </div>
                        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}

                        <a class="btn btn-secondary" href="{{ route('modules.index') }}"> {{ __('Back') }}</a>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        @endsection
