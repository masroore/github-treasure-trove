<div class="form-group{{ $errors->has('uid') ? ' has-error' : ''}}">
    {!! Form::label('uid', '아이디: ', ['class' => 'control-label']) !!}
    {!! Form::text('uid', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('uid', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', '이름: ', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group{{ $errors->has('nick') ? ' has-error' : ''}}">
    {!! Form::label('nick', '닉네임: ', ['class' => 'control-label']) !!}
    {!! Form::text('nick', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('nick', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
    {!! Form::label('email', 'Email: ', ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
    {!! Form::label('password', 'Password: ', ['class' => 'control-label']) !!}
    @php
        $passwordOptions = ['class' => 'form-control'];
        if ($formMode === 'create') {
            $passwordOptions = array_merge($passwordOptions, ['required' => 'required']);
        }
    @endphp
    {!! Form::password('password', $passwordOptions) !!}
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('roles') ? ' has-error' : ''}}">
    {!! Form::label('role', 'Role: ', ['class' => 'control-label']) !!}
    {{-- {!! Form::select('role_id', $roles, isset($user_roles) ? $user_roles : [], ['class' => 'form-control', 'multiple' => false]) !!} --}}
    <select name="role_id" class="form-control">
        @foreach ($roles as $item)
            <option value="{{  $item->id }}" >{{  $item->label }}</option>
        @endforeach
    </select>
    
</div>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
