@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit User</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($user, [
                            'method' => 'PATCH',
                            'url' => ['/admin/users', $user->id],
                            'class' => 'form-horizontal'
                        ]) !!}

                        {{-- @include ('admin.users.form', ['formMode' => 'edit']) --}}

                        <div class="form-group{{ $errors->has('uid') ? ' has-error' : ''}}">
                            {!! Form::label('uid', '아이디: ', ['class' => 'control-label']) !!}
                            {!! Form::text('uid', $user->uid, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('uid', '<p class="help-block">:message</p>') !!}
                        </div>
                        
                        
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                            {!! Form::label('name', '이름: ', ['class' => 'control-label']) !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                        
                        
                        <div class="form-group{{ $errors->has('nick') ? ' has-error' : ''}}">
                            {!! Form::label('nick', '닉네임: ', ['class' => 'control-label']) !!}
                            {!! Form::text('nick', $user->nick, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('nick', '<p class="help-block">:message</p>') !!}
                        </div>
                        
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                            {!! Form::label('email', 'Email: ', ['class' => 'control-label']) !!}
                            {!! Form::email('email', $user->email, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                        
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
                            {!! Form::label('password', 'Password: ', ['class' => 'control-label']) !!}
                            @php
                                $passwordOptions = ['class' => 'form-control'];
                            @endphp
                            {!! Form::password('password', $passwordOptions) !!}
                            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('roles') ? ' has-error' : ''}}">
                            {!! Form::label('role', 'Role: ', ['class' => 'control-label']) !!}
                            <select name="role_id" class="form-control">
                                @foreach ($roles as $item)
                                    <option value="{{  $item->id }}" {{  $item->id == $user->role_id ? 'selected' : '' }}>{{  $item->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Update' , ['class' => 'btn btn-primary']) !!}
                        </div>

                        

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
