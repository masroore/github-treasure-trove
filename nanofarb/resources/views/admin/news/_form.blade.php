@empty($page)
    {!! Form::hidden('locale', request('locale', \UrlAliasLocalization::getDefaultLocale())) !!}
    {!! Form::hidden('locale_bound', request('locale_bound', \Illuminate\Support\Str::uuid()->toString())) !!}
@else
    {!! Form::hidden('locale', request('locale', $page->locale)) !!}
@endempty

@include('admin.fields.field-checkbox', [
    'label' => 'Публиковать',
    'field_name' => 'publish',
    'status' => isset($node) ? $node->publish : 1,
])

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Название', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('teaser') ? 'has-error' : ''}}">
    {!! Form::label('teaser', 'Кратоке описание', ['class' => 'control-label']) !!}
    {!! Form::textarea('teaser', null, ['class' => 'form-control ck-editor ck-full', 'rows' => 4]) !!}
    {!! $errors->first('teaser', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('body') ? 'has-error' : ''}}">
    {!! Form::label('body', 'Контент', ['class' => 'control-label']) !!}
    {!! Form::textarea('body', null, ['class' => 'form-control ck-editor ck-full', 'rows' => 5]) !!}
    {!! $errors->first('body', '<p class="help-block">:message</p>') !!}
</div>


@empty($node)
<div class="form-group {{ $errors->has('url_alias') ? 'has-error' : ''}}">
    {!! Form::label('url_alias', 'URL-алиас', ['class' => 'control-label']) !!}
    {!! Form::text('url_alias', isset($node) ? optional($node->urlAlias)->alias : null, ['class' => 'form-control', isset($node) ? 'readonly' : '']) !!}
    {!! $errors->first('url_alias', '<p class="help-block">:message</p>') !!}
</div>
@endempty

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.news.create'),
    'url_store_and_close' => session('admin.news.index'),
    'url_destroy' => isset($node) ? route('admin.news.destroy', $node) : '',
    'url_after_destroy' => session('admin.news.index'),
    'url_close' => session('admin.news.index'),
])
