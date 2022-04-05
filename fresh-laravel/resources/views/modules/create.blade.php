@extends('layouts.admin')
@section('title', 'Modules')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Modules</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('modules.index') }}">Modules</a></div>
                    <div class="breadcrumb-item">Create Modules</div>
                </div>
            </div>
            {!! Form::open(['route' => 'modules.store', 'method' => 'POST']) !!}
            <div class="col-md-4 m-auto">
                <div class="card p-4">
                    <div class="card-header">{{ __('Create New Module') }} </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('name', __('Name')) }}
                            {!! Form::text('name', null, ['placeholder' => __('Name'), 'required' => true, 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('permissions', __('Permissions'), ['class' => 'col-md-4 col-form-label']) }}

                            <div class="col-md-9 col-form-label">
                                <div class="form-check form-check-inline mr-1">
                                    {{ Form::checkbox('permissions[]', 'M'), ['class' => 'form-check-label', 'id' => 'inline-checkbox1'] }}
                                    {{ Form::label('manage', __('Manage'), ['class' => 'form-check-label']) }}


                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    {{ Form::checkbox('permissions[]', 'C'), ['class' => 'form-check-label', 'id' => 'inline-checkbox2'] }}
                                    {{ Form::label('create', __('Create'), ['class' => 'form-check-label']) }}

                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    {{ Form::checkbox('permissions[]', 'D'), ['class' => 'form-check-label', 'id' => 'inline-checkbox3'] }}
                                    {{ Form::label('delete', __('Delete'), ['class' => 'form-check-label']) }}

                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    {{ Form::checkbox('permissions[]', 'S'), ['class' => 'form-check-label', 'id' => 'inline-checkbox4'] }}
                                    {{ Form::label('show', __('Show'), ['class' => 'form-check-label']) }}

                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    {{ Form::checkbox('permissions[]', 'E'), ['class' => 'form-check-label', 'id' => 'inline-checkbox5'] }}
                                    {{ Form::label('edit', __('Edit'), ['class' => 'form-check-label']) }}

                                </div>
                            </div>
                        </div>
                        {{ Form::submit(__('Submit'), ['class' => 'btn btn-primary']) }}

                        <a class="btn btn-secondary" href="{{ route('modules.index') }}"> {{ __('Back') }}</a>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        @endsection
