<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Название', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_close' => session('admin.forms.index'),
    'url_destroy' => isset($page) ? route('admin.forms.destroy', $page) : '',
    'url_after_destroy' => session('admin.forms.index'),
    'url_close' => session('admin.forms.index'),
])
