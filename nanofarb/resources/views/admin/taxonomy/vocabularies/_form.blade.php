<input type="hidden" name="vocabulary" value="{{ request('vocabulary', $term->vocabulary ?? null) }}">
<input type="hidden" name="parent_id" value="{{ request('parent_id', $term->parent_id ?? null) }}">
<div class="row">
    <div class="col-lg-6">
        {{--
        @include('admin.fields.field-checkbox', [
            'label' => 'Публиковать',
            'field_name' => 'publish',
            'status' => isset($term) ? $term->publish : 1,
        ])
        --}}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Название', ['class' => 'control-label',]) !!}
            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Например: Яблуко', 'required']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>

        @empty($vocabulary)
        <div class="form-group {{ $errors->has('system_name') ? 'has-error' : ''}}">
            {!! Form::label('system_name', 'Систеное имя', ['class' => 'control-label',]) !!}
            {!! Form::text('system_name', null, ['class' => 'form-control','placeholder' => 'Например: Яблуко', 'required']) !!}
            {!! $errors->first('system_name', '<p class="help-block">:message</p>') !!}
        </div>
        @endempty

        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            {!! Form::label('description', 'Описание', ['class' => 'control-label',]) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ck-editor ck-small','placeholder' => 'Приклад: Опис про яблуко']) !!}
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-lg-6">
        
    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.vocabularies.create'),
    'url_store_and_close' => session('admin.vocabularies.index'),
    'url_destroy' => isset($vocabulary) ? route('admin.vocabularies.destroy', $vocabulary) : '',
    'url_after_destroy' => session('admin.vocabularies.index'),
    'url_close' => session('admin.vocabularies.index'),
])
