@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Аккаунт',
    ]
@endphp

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Данные аккаунта</h3>
                    </div>
                    <div class="box-body">
                        {!! Form::model($user, [
                            'method' => 'PATCH',
                            'route' => 'admin.account.update',
                            'files' => true
                        ]) !!}
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                {!! Form::label('name', 'Имя', ['class' => 'control-label',]) !!}
                                {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Bill']) !!}
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                                {!! Form::label('last_name', 'Фамилия', ['class' => 'control-label',]) !!}
                                {!! Form::text('last_name', null, ['class' => 'form-control','placeholder' => 'Bill']) !!}
                                {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                {!! Form::label('email', 'Email', ['class' => 'control-label',]) !!}
                                {!! Form::text('email', null, ['class' => 'form-control','placeholder' => 'example@app.com']) !!}
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                {!! Form::label('password', 'Пароль', ['class' => 'control-label',]) !!}
                                {!! Form::password('password',  ['class' => 'form-control',]) !!}
                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                                {!! Form::label('password_confirmation', 'Подтверждение пароля', ['class' => 'control-label',]) !!}
                                {!! Form::password('password_confirmation', ['class' => 'form-control',]) !!}
                                {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                            </div>
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop