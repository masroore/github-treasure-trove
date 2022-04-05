<input type="hidden" name="product_group_id" value="{{ request('product_group_id') }}">

@if(empty($product) || Route::currentRouteNamed('*create'))
    {!! Form::hidden('locale', request('locale', \UrlAliasLocalization::getDefaultLocale())) !!}
    {!! Form::hidden('locale_bound', request('locale_bound', \Illuminate\Support\Str::uuid()->toString())) !!}
@else
    {!! Form::hidden('locale', request('locale', $product->locale)) !!}
@endempty


<div class="row">
    <div class="col-lg-6">
        @include('admin.fields.field-checkbox', [
            'label' => 'Публиковать',
            'field_name' => 'publish',
            'status' => isset($product) ? $product->publish : 1,
        ])

        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Название', ['class' => 'control-label']) !!}
            {!! Form::text('name', isset($product) ? $product->name : null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('sku') ? 'has-error' : ''}}">
            {!! Form::label('sku', 'Артикул', ['class' => 'control-label']) !!}
            {!! Form::text('sku', isset($product) ? $product->sku : null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('sku', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
            {!! Form::label('price', 'Цена', ['class' => 'control-label']) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                {!! Form::number('price', isset($product) ? $product->price / 100 : null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('price_old') ? 'has-error' : ''}}">
            {!! Form::label('price_old', 'Цена (старая)', ['class' => 'control-label']) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                {!! Form::text('price_old', isset($product) ? $product->price_old / 100 : null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('price_old', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('availability') ? 'has-error' : ''}}">
            {!! Form::label('availability', 'Наличие', ['class' => 'control-label']) !!}
            {!! Form::select('availability', [1 => 'Есть в наличии', 0 => 'Нет в наличии'], null, ['class' => 'form-control']) !!}
            {!! $errors->first('availability', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            {!! Form::label('description', 'Описание', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', isset($product) ? $product->description : null, ['class' => 'form-control ck-editor ck-small', 'rows' => 5]) !!}
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('data.applying') ? 'has-error' : ''}}">
            {!! Form::label('data[applying]', 'Характеристики', ['class' => 'control-label']) !!}
            {!! Form::textarea('data[applying]', isset($product) ? ($product->data['applying'] ?? '') : null, ['class' => 'form-control ck-editor ck-small', 'rows' => 5]) !!}
            {!! $errors->first('data.applying', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('data.composition') ? 'has-error' : ''}}">
            {!! Form::label('data[composition]', 'Состав', ['class' => 'control-label']) !!}
            {!! Form::textarea('data[composition]', isset($product) ? ($product->data['composition'] ?? '') : null, ['class' => 'form-control ck-editor ck-small', 'rows' => 5]) !!}
            {!! $errors->first('data.composition', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('created_at') ? 'has-error' : ''}}">
            {!! Form::label('created_at', 'Дата создания', ['class' => 'control-label']) !!}
            {!! Form::datetime('created_at', null, ['class' => 'form-control']) !!}
            {!! $errors->first('created_at', '<p class="help-block">:message</p>') !!}
            <p class="help-block small">* Поле используется для сортировки по умолчанию</p>
        </div>

    </div>

    <div class="col-lg-6">

        @if(1 || !Route::currentRouteNamed('*create')
            && isset($product) && $product->group->default_product_id === $product->id
            || empty($product))
            @include('admin.fields.field-select2-tree-ajax', [
                'label' => 'Основная категория',
                'field_name' => 'category_id',
                // 'multiple' => 1,
                // 'disabled' => 0,
                'required' => 1,
                'help_block' => '* Для хлебных крошек и URL-алиасов',
                'data_url_tree' => route('admin.terms.treeselect', [
                    'vocabulary' => 'product_categories',
                    'selected' => isset($product) ? $product->category_id : [],
                    'locale' => isset($product) ? $product->locale : request('locale'),
                    'old' => old('category_id'),
                ]),
            ])
        @elseif(isset($product) && $product->group)
            <input type="hidden" name="category_id" value="{{ $product->group->product->category_id }}">
        @endif

        @include('admin.fields.field-images-uploaded-sortable',[
            'label' => 'Изображения',
            'field_name' => 'images',
            'entity' => isset($product) && Route::currentRouteNamed('*edit') ? $product : null,
        ])

        @include('admin.fields.field-treeview', [
            'label' => 'Категории товара',
            'field_name' => 'terms[categories]',
            'url_tree' => route('admin.terms.treeview', [
                'vocabulary' => 'product_categories',
                'selected' => isset($product) ? $product->txCategories->pluck('id')->toArray() : [],
                'locale' => isset($product) ? $product->locale : request('locale'),
                'old' => old('terms.categories'),
            ]),
        ])

        <div class="box box-warning box-solid" style="display: none;">
            <div class="box-header">
                <h3 class="box-title">Дополнетельные параметры товара</h3>
            </div>
            <div class="box-body">
                <div class="form-group {{ $errors->has('data.weight') ? 'has-error' : ''}}">
                    {!! Form::label('data[weight]', 'Вес, кг.', ['class' => 'control-label']) !!}
                    {!! Form::number('data[weight]', isset($product) ? ($product->data['weight'] ?? 0) : null, ['class' => 'form-control', 'step' => "0.001"]) !!}
                    {!! $errors->first('data.weight', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('data.length') ? 'has-error' : ''}}">
                    {!! Form::label('data[length]', 'Длина, см.', ['class' => 'control-label']) !!}
                    {!! Form::number('data[length]', isset($product) ? ($product->data['length'] ?? 0) : null, ['class' => 'form-control', 'step' => "0.1"]) !!}
                    {!! $errors->first('data.length', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('data.width') ? 'has-error' : ''}}">
                    {!! Form::label('data[width]', 'Ширина, см.', ['class' => 'control-label']) !!}
                    {!! Form::number('data[width]', isset($product) ? ($product->data['width'] ?? 0) : null, ['class' => 'form-control', 'step' => "0.1"]) !!}
                    {!! $errors->first('data.width', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('data.height') ? 'has-error' : ''}}">
                    {!! Form::label('data[height]', 'Высота, см.', ['class' => 'control-label']) !!}
                    {!! Form::number('data[height]', isset($product) ? ($product->data['height'] ?? 0) : null, ['class' => 'form-control', 'step' => "0.1"]) !!}
                    {!! $errors->first('data.height', '<p class="help-block">:message</p>') !!}
                </div>

            </div>
        </div>
    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.products.create', ['product_group_id' => isset($product) ? $product->product_group_id : null]),
    'url_store_and_close' => session('admin.products.index'),
    'url_destroy' => isset($product) ? route('admin.products.destroy', $product) : '',
    'url_after_destroy' => session('admin.products.index'),
    'url_close' => session('admin.products.index'),
])