<div class="row">
    <div class="col-lg-6">

        @include('admin.fields.field-checkbox', [
            'label' => 'Активный',
            'field_name' => 'active',
            'status' => isset($user) ? $user->active : 1,
        ])

        @if(!empty($user->data['password']))
        <div class="callout callout-warning">
            <h4>Внимание!</h4>
            <p>Для пользователя автоматически сгенерирован пароль: <strong>{{ $user->data['password'] }}</strong></p>
        </div>
        @endif

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
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
            {!! Form::label('phone', 'Phone', ['class' => 'control-label']) !!}
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
            {!! Form::label('password', 'Новый пароль', ['class' => 'control-label']) !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
            {!! Form::label('password_confirmation', 'Подтверждение пароля', ['class' => 'control-label',]) !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control',]) !!}
            {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
        </div>

        @include('admin.fields.field-select2-static', [
            'label' => 'Роль',
            'field_name' => 'roles',
            'multiple' => 1,
            'max' => 1,
            'disabled' => 0,
            'required' => 1,
            'attributes' => \Spatie\Permission\Models\Role::all()->pluck('title', 'name')->toArray(),
            'selected' => isset($user) ? $user->roles->pluck('name')->toArray() : [],
            'old' => old('roles')
        ])

    </div>
</div>
@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.users.create'),
    'url_store_and_close' => session('admin.users.index'),
    'url_destroy' => isset($user) ? route('admin.users.destroy', $user) : '',
    'url_after_destroy' => session('admin.users.index'),
    'url_close' => session('admin.users.index'),
])
