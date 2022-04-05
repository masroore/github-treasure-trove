@empty($page)
    {!! Form::hidden('locale', request('locale', \UrlAliasLocalization::getDefaultLocale())) !!}
    {!! Form::hidden('locale_bound', request('locale_bound', \Illuminate\Support\Str::uuid()->toString())) !!}
@endempty

@include('admin.fields.field-checkbox', [
    'label' => 'Публиковать',
    'field_name' => 'publish',
    'status' => isset($page) ? $page->publish : 1,
])

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Название', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('body') ? 'has-error' : ''}}">
    {!! Form::label('body', 'Контент', ['class' => 'control-label']) !!}
    {!! Form::textarea('body', null, ['class' => 'form-control ck-editor ck-full', 'rows' => 5]) !!}
    {!! $errors->first('body', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('blade') ? 'has-error' : ''}}">
    {!! Form::label('blade', 'Шаблон', ['class' => 'control-label']) !!}
    {!! Form::select('blade', [
        null => 'По умолчанию',
        'front.pages.home' => 'Домашняя страница',
        //'front.pages.home-uk' => 'Домашняя страница (uk)',
        'front.pages.about' => 'О нас',
        //'front.pages.payment' => 'Оплата и доставка',
        //'front.pages.policy' => 'Политика конф.',
        //'front.pages.cooperation' => 'Сотрудничество',
        //'front.pages.buy' => 'Где купить',
        'front.pages.faq' => 'Вопросы и контакты',
        'front.pages.request' => 'Заявки',
        ], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => '-1']) !!}
    {!! $errors->first('blade', '<p class="help-block">:message</p>') !!}
</div>

@empty($page)
<div class="form-group {{ $errors->has('url_alias') ? 'has-error' : ''}}">
    {!! Form::label('url_alias', 'URL-алиас', ['class' => 'control-label']) !!}
    {!! Form::text('url_alias', isset($page) ? optional($page->urlAlias)->alias : null, ['class' => 'form-control', isset($page) ? 'readonly' : '']) !!}
    {!! $errors->first('url_alias', '<p class="help-block">:message</p>') !!}
</div>
@endempty

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.pages.create'),
    'url_store_and_close' => session('admin.pages.index'),
    'url_destroy' => isset($page) ? route('admin.pages.destroy', $page) : '',
    'url_after_destroy' => session('admin.pages.index'),
    'url_close' => session('admin.pages.index'),
])
