<input type="hidden" name="vocabulary" value="{{ request('vocabulary', $term->vocabulary ?? null) }}">
<input type="hidden" name="parent_id" value="{{ request('parent_id', $term->parent_id ?? null) }}">
<div class="row">
    <div class="col-lg-6">
        @include('admin.fields.field-checkbox', [
            'label' => 'Публиковать',
            'field_name' => 'publish',
            'status' => isset($term) ? $term->publish : 1,
        ])

        @if(empty($term) && in_array(request('vocabulary'), ['product_categories', 'types_trade_services']))
            {!! Form::hidden('locale', request('locale', \UrlAliasLocalization::getDefaultLocale())) !!}
            {!! Form::hidden('locale_bound', request('locale_bound', \Illuminate\Support\Str::uuid()->toString())) !!}
            {!! Form::hidden('vocabulary', request('vocabulary')) !!}
        @endif

        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Название', ['class' => 'control-label',]) !!}
            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Например: Яблуко']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            {!! Form::label('description', 'Описание', ['class' => 'control-label',]) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ck-editor ck-small','placeholder' => 'Приклад: Опис про яблуко']) !!}
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-lg-6">

    @if($vocabulary->system_name == 'product_categories')
        @include('admin.fields.field-select2-static', [
            'label' => 'Атрибуты',
            'field_name' => 'attributes',
            'multiple' => 1,
            'disabled' => 0,
            'attributes' => $attributes->pluck('title', 'id')->toArray(),
            'selected' => isset($term) ? $term->attrs->pluck('id')->toArray() : [],
            'old' => old('attributes')
        ])

        @include('admin.fields.field-image-uploaded',[
            'label' => 'Изображение',
            'field_name' => 'image',
            'entity' => isset($term) ? $term : null,
        ])

    @endif

    @if($vocabulary->system_name == 'order_statuses' || $vocabulary->system_name == 'payment_statuses')
        @include('admin.fields.field-select2-static', [
               'label' => 'Класс для отображения в админке',
               'field_name' => 'options[admin_style]',
               'attributes' => ['label label-success' => 'Success', 'label label-warning' => 'Warning', 'label label-danger' => 'Danger', 'label label-info' => 'Info', ],
               'selected' => isset($term->options['admin_style']) ? $term->options['admin_style'] : null,
           ])
    @endif
{{--

        @include('admin.fields.field-images-uploaded',[
             'label' => 'Изображения',
             'field_name' => 'images',
             'entity' => isset($term) ? $term : null,
        ])

        @include('admin.fields.field-image-uploaded',[
            'label' => 'Изображение',
            'field_name' => 'image',
            'entity' => isset($term) ? $term : null,
        ])

        @include('admin.fields.field-images-uploaded',[
            'label' => 'Изображения',
            'field_name' => 'images',
            'entity' => isset($term) ? $term : null,
        ])

        @include('admin.fields.field-images-uploaded-sortable',[
            'label' => 'Изображения',
            'field_name' => 'images',
            'entity' => isset($term) ? $term : null,
        ])

        @include('admin.fields.field-file-uploaded',[
            'label' => 'Файл',
            'field_name' => 'file',
            'entity' => isset($term) ? $term : null,
        ])

        @include('admin.fields.field-files-uploaded',[
            'label' => 'Файлы',
            'field_name' => 'files',
            'entity' => isset($term) ? $term : null,
        ])

        @include('admin.fields.field-files-uploaded-sortable',[
            'label' => 'Файлы',
            'field_name' => 'files',
            'entity' => isset($term) ? $term : null,
        ])
--}}

    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.terms.create', ['vocabulary' => request('vocabulary', $term->vocabulary ?? null)]),
    'url_store_and_close' => session('admin.terms.index'),
    'url_destroy' => isset($term) ? route('admin.terms.destroy', $term) : '',
    'url_after_destroy' => session('admin.terms.index'),
    'url_close' => session('admin.terms.index'),
])
