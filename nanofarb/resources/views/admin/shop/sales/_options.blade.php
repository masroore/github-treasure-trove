<input type="hidden" name="product_group_id" value="{{ request('product_group_id') }}">
<div class="row">
    <div class="col-lg-6">

        @if(in_array($sale->type, [\App\Models\Shop\Sale::TYPE_PRODUCT, \App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT, \App\Models\Shop\Sale::TYPE_PROM_CODE_DISCOUNT_SUM_ORDER]))
            @include('admin.fields.field-radio-group', [
                //'label' => 'Тип пути',
                'field_name' => 'discount_type',
                'selected' => isset($sale) ? $sale->discount_type : \App\Models\Shop\Sale::DISCOUNT_TYPE_PERCENT,
                'attributes' => [\App\Models\Shop\Sale::DISCOUNT_TYPE_PERCENT => 'Скидка "Процент от суммы" (%)', \App\Models\Shop\Sale::DISCOUNT_TYPE_SUM => 'Скидка "Фиксированная сумма" ('.Currency::getDefault('symbol').')',]
            ])

            <div class="form-group {{ $errors->has('discount') ? 'has-error' : ''}}">
                {!! Form::label('discount', 'Значение скидки', ['class' => 'control-label']) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bullseye"></i></span>
                    {!! Form::number('discount', isset($sale) ? $sale->discount_sum : null, ['class' => 'form-control']) !!}
                </div>
                {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
            </div>
        @endif

        @if(in_array($sale->type, [\App\Models\Shop\Sale::TYPE_FREE_SHIPPING_CONDITIONS,]))
            {{--
            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('data[min_sum]', 'Применять при минимальной сумме заказа (товаров), руб.', ['class' => 'control-label']) !!}
                {!! Form::number('data[min_sum]', isset($sale) && isset($sale->data['min_sum']) ? $sale->data['min_sum'] / 100 : 0, ['class' => 'form-control', 'required', 'step' => 1, 'min' => 0, 'autocomplete' => 'off']) !!}
                {!! $errors->first('data[min_sum]', '<p class="help-block">:message</p>') !!}
            </div>
            --}}
            {{--
            <div class="">
                <label>
                    <input type="hidden" value="0" name="data[only_delivery_pwz]">
                    <input type="checkbox" value="1" name="data[only_delivery_pwz]" @if(!empty($sale->data['only_delivery_pwz'])) checked @endif> + если выбрано "Доставка до пункта самовывоза"
                </label>
            </div>
            --}}
        @endif

        @if(in_array($sale->type, [\App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT, \App\Models\Shop\Sale::TYPE_PROM_CODE_FREE_ORDER, \App\Models\Shop\Sale::TYPE_PROM_CODE_DISCOUNT_SUM_ORDER]))
        <div class="box box-warning box-solid">
            <div class="box-header">
                <h3 class="box-title">Генерация промокодов</h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            @if(in_array($sale->type, [\App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT_PRESENT]))
                                <a
                                    class="btn btn-default pull-left"
                                    data-toggle="modal"
                                    data-target="#modal-add-sale-promocode"
                                >Создать</a>
                            @endif
                            <a
                                class="btn btn-default pull-left"
                                data-toggle="modal"
                                data-target="#modal-generate-sale-promocode"
                            >Генерировать</a>
                        </div>
                    </div>
                </div>

                <div id="promo-codes-table">
                    @if($sale->promoCodes->count())
                        @include('admin.shop.sales.inc.promo-codes-table', [
                            'promoCodes' => $sale->promoCodes()->paginate(50),
                            'sale' => $sale,
                        ])
                    @endif
                </div>

            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-6">
        @if(in_array($sale->type, [\App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT_PRESENT,]))
            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('data[min_sum]', 'Применять при минимальной сумме заказа (товаров), '.\App\Helpers\Currency\Facades\Currency::getDefault('symbol'), ['class' => 'control-label']) !!}
                {!! Form::number('data[min_sum]', isset($sale) && isset($sale->data['min_sum']) ? $sale->data['min_sum'] / 100 : null, ['class' => 'form-control', 'required', 'step' => 1, 'min' => 0, 'autocomplete' => 'off']) !!}
                {!! $errors->first('data[min_sum]', '<p class="help-block">:message</p>') !!}
            </div>
        @endif

        @if(in_array($sale->type, [\App\Models\Shop\Sale::TYPE_PRODUCT, \App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT, \App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT_PRESENT]))
            @include('admin.fields.field-select2-ajax-autocomplete', [
                'label' => 'Применять к товарам',
                'data_url' => route('admin.products.autocomplete', ['locale' => isset($sale) ? $sale->locale : \UrlAliasLocalization::getDefaultLocale(),]),
                'field_name' => 'products',
                'multiple' => 1,
                'disabled' => 0,
                'selected' => isset($sale) ? $sale->products->pluck('name', 'id')->toArray() : [/*TODO*/],
                'old' => old('products')
            ])
        @endif

        @if(in_array($sale->type, [\App\Models\Shop\Sale::TYPE_PRODUCT, \App\Models\Shop\Sale::TYPE_PROM_CODE_PRODUCT]))
            @include('admin.fields.field-treeview', [
                'label' => 'Применять к категориям товаров',
                'field_name' => 'terms[categories]',
                'url_tree' => route('admin.terms.treeview', [
                    'vocabulary' => 'product_categories',
                    'selected' => isset($sale) ? $sale->terms->pluck('id')->toArray() : [],
                    'locale' => isset($sale) ? $sale->locale : \UrlAliasLocalization::getDefaultLocale(),
                    'old' => old('terms.categories'),
                ]),
            ])
        @endif
    </div>
</div>

@include('admin.fields.field-form-buttons', [
    'url_store_and_create' => route('admin.sales.create'),
    'url_store_and_close' => session('admin.sales.index'),
    'url_destroy' => isset($product) ? route('admin.sales.destroy', $sale) : '',
    'url_after_destroy' => session('admin.sales.index'),
    'url_close' => session('admin.sales.index'),
])

@push('modals')
    <div class="modal fade" id="modal-add-sale-promocode">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ручное создание промокода</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.sale-promo-codes.store') }}" method="POST" class="js-ajax-form-submit">
                        @csrf
                        <input type="hidden" name="sale_id" value="@isset($sale) {{$sale->id}} @endisset">
                        <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
                            {!! Form::label('code', 'Промокод:', ['class' => 'control-label']) !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'required', 'placeholder' => "A4F-RDF5-RE6"]) !!}
                            {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
                        </div>

                        @include('admin.fields.field-select2-static', [
                            'label' => 'Тип:',
                            'field_name' => 'used_limit',
                            'multiple' => 0,
                            'required' => 1,
                            'attributes' => [0 => 'Многоразовый', 1 => 'Одноразовый'],
                            'selected' => 0,
                        ])

                        @include('admin.fields.field-daterangepicker', [
                            'label' => 'Период действия:',
                            'field_name' => 'range',
                            'field_name_start' => 'start_at',
                            'field_name_end' => 'end_at',
                            'date_start' => isset($sale) && $sale->start_at ? $sale->start_at->format('m/d/Y') : \Carbon\Carbon::now()->format('m/d/Y'),
                            'date_end' => isset($sale) && $sale->end_at ? $sale->end_at->format('m/d/Y') : \Carbon\Carbon::now()->addDay(14)->format('m/d/Y'),
                        ])
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-generate-sale-promocode">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Автоматическое генерирование промокодов</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.sale-promo-codes.generate') }}" method="POST" class="js-ajax-form-submit">
                        @csrf
                        <input type="hidden" name="sale_id" value="@isset($sale) {{$sale->id}} @endisset">

                        @include('admin.fields.field-select2-static', [
                            'label' => 'Количество:',
                            'field_name' => 'amount',
                            'multiple' => 0,
                            'required' => 1,
                            'attributes' => array_combine([1, 5, 10, 50, 100, 500], [1, 5, 10, 50, 100, 500]),
                            'selected' => 1,
                        ])

                        @include('admin.fields.field-select2-static', [
                            'label' => 'Тип:',
                            'field_name' => 'used_limit',
                            'multiple' => 0,
                            'required' => 1,
                            'attributes' => [0 => 'Многоразовый', 1 => 'Одноразовый'],
                            'selected' => 0,
                        ])
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Генерировать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
@endpush