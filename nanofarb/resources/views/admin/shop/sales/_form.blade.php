{{--<input type="hidden" name="product_group_id" value="{{ request('product_group_id') }}">--}}
@empty($sale)
    {!! Form::hidden('locale', request('locale', \UrlAliasLocalization::getDefaultLocale())) !!}
    {!! Form::hidden('locale_bound', request('locale_bound', \Illuminate\Support\Str::uuid()->toString())) !!}
@else
    {!! Form::hidden('locale', request('locale', $sale->locale)) !!}
@endempty

<div class="row">
    <div class="col-lg-6">

        @include('admin.fields.field-checkbox', [
            'label' => 'Публиковать',
            'field_name' => 'publish',
            'status' => isset($sale) ? $sale->publish : true,
        ])

        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Название', ['class' => 'control-label']) !!}
            {!! Form::text('name', isset($sale) ? $sale->name : null, ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
            {!! Form::label('type', 'Тип способа (условие) начисления акционной скидки', ['class' => 'control-label']) !!}
            {!! Form::select('type', \App\Models\Shop\Sale::$types, null, ['class' => 'form-control select2',  'data-minimum-results-for-search' => '-1']) !!}
            {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
        </div>

        {{--
        <div class="form-group {{ $errors->has('data.msg_after_prepare') ? 'has-error' : ''}}">
            {!! Form::label('data[msg_after_prepare]', 'Сообщение для клиента после применения', ['class' => 'control-label']) !!}
            {!! Form::textarea('data[msg_after_prepare]', isset($sale) ? ($sale->data['msg_after_prepare'] ?? '') : null, ['class' => 'form-control ck-editor ck-mini', 'placeholder' => 'Скидка 10% активирована']) !!}
            {!! $errors->first('data.msg_after_prepare', '<p class="help-block">:message</p>') !!}
        </div>
        --}}

        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            {!! Form::label('description', 'Описание', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', isset($sale) ? $sale->description : null, ['class' => 'form-control ck-editor ck-small', 'rows' => 5]) !!}
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-lg-6">

        @include('admin.fields.field-checkbox', [
            'label' => 'Бессрочная',
            'field_name' => 'dateless',
            'status' => isset($sale) ? $sale->dateless : true,
            'help_block' => '* Указанный ниже срок проведения не будет учитываться'
        ])


        @include('admin.fields.field-daterangepicker', [
            'label' => 'Срок проведения:',
            'field_name' => 'range',
            'field_name_start' => 'start_at',
            'field_name_end' => 'end_at',
            'date_start' => isset($sale) && $sale->start_at ? $sale->start_at->format('m/d/Y') : \Carbon\Carbon::now()->format('m/d/Y'),
            'date_end' => isset($sale) && $sale->end_at ? $sale->end_at->format('m/d/Y') : \Carbon\Carbon::now()->addDay(14)->format('m/d/Y'),
            'show_saved' => true,
        ])

        @include('admin.fields.field-image-uploaded',[
            'label' => 'Изображение',
            'field_name' => 'image',
            'entity' => isset($sale) ? $sale : null,
        ])

    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.sales.create'),
    'url_store_and_close' => session('admin.sales.index'),
    'url_destroy' => isset($sale) ? route('admin.sales.destroy', $sale) : '',
    'url_after_destroy' => session('admin.sales.index'),
    'url_close' => session('admin.sales.index'),
])