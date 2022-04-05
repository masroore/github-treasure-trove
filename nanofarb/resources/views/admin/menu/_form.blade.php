<div class="row">
    <input type="hidden" name="menu_id" value="{{ request('menu_id', $menuItem->menu_id ?? null) }}">
    <input type="hidden" name="parent_id" value="{{ request('parent_id', $menuItem->parent_id ?? null) }}">
    <div class="col-lg-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Название', ['class' => 'control-label',]) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Например: О компании', 'autocomplete' => 'off']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>

        @include('admin.fields.field-radio-group', [
            'field_name' => 'path_type',
            'selected' => isset($menuItem) ? $menuItem->path_type : 1,
            'attributes' => [1 => 'URL-путь', 2 => 'URL-алиас',]
        ])

        <div class="form-group {{ $errors->has('path') ? 'has-error' : ''}}">
            {!! Form::label('path', 'URL-путь', ['class' => 'control-label',]) !!}
            {!! Form::text('path', null, ['class' => 'form-control','placeholder' => 'Например: http://site.app/about', 'autocomplete' => 'off']) !!}
            {!! $errors->first('path', '<p class="help-block">:message</p>') !!}
        </div>

        @include('admin.fields.field-select2-ajax-autocomplete', [
            'label' => 'URL-алиас',
            'field_name' => 'url_alias_id',
            'data_url' => route('admin.url-aliases.autocomplete'),
            'multiple' => 0,
            'disabled' => 0,
            'selected' => isset($menuItem) && ($menuItem->urlAlias) ? [$menuItem->urlAlias->id => url($menuItem->urlAlias->alias)] : null,
            'old' => old('url_alias_id')
        ])

    </div>
    <div class="col-lg-6">

        <div class="form-group {{ $errors->has('locale') ? 'has-error' : ''}}">
            {!! Form::label('locale', 'Locale', ['class' => 'control-label',]) !!}
            {!! Form::select('locale', [null => '--не выбрано--',] + \UrlAliasLocalization::getSupportedLocalesForSelect(), null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => '-1']) !!}
            {!! $errors->first('locale', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('target') ? 'has-error' : ''}}">
            {!! Form::label('target', 'Target', ['class' => 'control-label',]) !!}
            {!! Form::select('target', [null => 'По умолчанию', '_blank' => '_blank',], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => '-1']) !!}
            {!! $errors->first('target', '<p class="help-block">:message</p>') !!}
        </div>

        @if($menu->system_name == 'slider_in_home')
            @include('admin.fields.field-image-uploaded',[
                'label' => 'Изображение (Desktop)',
                'field_name' => 'img_desktop',
                'entity' => isset($menuItem) ? $menuItem : null,
            ])
            @include('admin.fields.field-image-uploaded',[
                'label' => 'Изображение (Tablet)',
                'field_name' => 'img_tablet',
                'entity' => isset($menuItem) ? $menuItem : null,
            ])
            @include('admin.fields.field-image-uploaded',[
                'label' => 'Изображение (Mobile)',
                'field_name' => 'img_mobile',
                'entity' => isset($menuItem) ? $menuItem : null,
            ])
        @else
            @include('admin.fields.field-image-uploaded',[
                'label' => 'Изображение',
                'field_name' => 'image',
                'entity' => isset($menuItem) ? $menuItem : null,
            ])
        @endif

        @if($menu->system_name == 'admin_menu')

            @include('admin.fields.field-checkbox', [
                'label' => 'Разделитель (Header)',
                'field_name' => 'data[header]',
                'status' => isset($menuItem) && isset($menuItem->data['header']) ? $menuItem->data['header'] : 0,
            ])

            <div class="form-group {{ $errors->has('data.icon') ? 'has-error' : ''}}">
                {!! Form::label('data[icon]', 'Класс иконки', ['class' => 'control-label',]) !!}
                {!! Form::text('data[icon]', isset($menuItem) && isset($menuItem->data['icon']) ? $menuItem->data['icon'] : null, ['class' => 'form-control', 'placeholder' => 'Например: О компании', 'autocomplete' => 'off']) !!}
                {!! $errors->first('data.icon', '<p class="help-block">:message</p>') !!}
            </div>

            @include('admin.fields.field-select2-static', [
                'label' => 'Права для доступа (ИЛИ)',
                'field_name' => 'data[permissions]',
                'multiple' => 1,
                'max' => 8,
                'disabled' => 0,
                'required' => 0,
                'attributes' => \Spatie\Permission\Models\Permission::get()->pluck('title', 'name')->toArray(),
                'selected' => isset($menuItem) ? ($menuItem->data['permissions'] ?? []) : [],
            ])

            <div class="form-group {{ $errors->has('data.pattern_url') ? 'has-error' : ''}}">
                {!! Form::label('data[pattern_url]', 'RegExp-шаблон пути (активный пункт)', ['class' => 'control-label',]) !!}
                {!! Form::text('data[pattern_url]', isset($menuItem) && isset($menuItem->data['pattern_url']) ? $menuItem->data['pattern_url'] : null, ['class' => 'form-control', 'placeholder' => 'Например: О компании', 'autocomplete' => 'off']) !!}
                {!! $errors->first('data.pattern_url', '<p class="help-block">:message</p>') !!}
                <p class="help-block small">* Правило определения активности пункта меню</p>
            </div>

        @endif

    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.menu-items.create', ['menu_id' => request('menu_id', $menuItem->menu_id ?? null)]),
    'url_store_and_close' => session('admin.menu-items.index'),
    'url_destroy' => isset($menuItem) ? route('admin.menu-items.destroy', $menuItem) : '',
    'url_after_destroy' => session('admin.menu-items.index'),
    'url_close' => session('admin.menu-items.index'),
])