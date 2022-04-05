@extends('layouts.admin')
@section('title', 'Roles')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Roles</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('roles.index') }}">Roles</a></div>
                    <div class="breadcrumb-item">Edit Roles</div>
                </div>
            </div>
            {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
            <div class="col-md-4 m-auto">
                <div class="card">
                    <div class="card-header">{{ __('Edit Roles') }}
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('name', __('Name')) }}

                            {!! Form::text('name', null, ['placeholder' => __('Name'), 'class' => 'form-control']) !!}
                        </div>
                        <div>
                            {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}

                            <a class="btn btn-secondary" href="{{ route('roles.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        @endsection
