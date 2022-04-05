@extends('layouts.admin')
@section('title', 'Users')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User Edit</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>
                    <div class="breadcrumb-item">User Edit</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-4 m-auto">
                        <div class="card p-4">
                            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'Put', 'enctype' => 'multipart/form-data']) !!}
        
                            <div class="form-group ">
                                {{ Form::label('name', __('Name')) }}
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    {!! Form::text('name', null, ['class' => 'form-control', ' required','placeholder' => 'Enter Name']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', __('Email')) }}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    {!! Form::text('email', null, ['class' => 'form-control', ' required','placeholder' => 'Enter Email Address']) !!}
                                </div>
                            </div>
                            {{-- <div class="form-group ">
                                {{ Form::label('password', __('Password')) }}
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    {!! Form::password('password', ['class' => 'form-control', ' required','placeholder' => 'Enter  Password']) !!}
                                </div>
                            </div>
                            <div class="form-group ">
                                {{ Form::label('confirm-password', __('Confirm Password')) }}
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    {{ Form::password('confirm-password', ['class' => 'form-control', ' required','placeholder' => 'Enter Confirm Password']) }}
                                </div>
                            </div> --}}
        
                            <div class="form-group">
                                {{ Form::label('roles', __('Role')) }}
                                <div class="input-group ">
        
                                    {!! Form::select('roles', $roles, $user->type, ['class' => 'form-control', 'id' => 'role']) !!}
        
                                </div>
                            </div>
                          
                            <div class="btn-flt">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

