@extends('admin.app')


@php
    $content_header = [
        'page_title' => 'Настройки магазина',
        'url_back' => '',
        'url_create' => '',
    ];
@endphp

@section('content')
    <section class="content">
        @php($locale = request('var_locale', \UrlAliasLocalization::getDefaultLocale()))
        @include('admin.variables._locales')
        <div class="row">
            <div class="col-md-6">
                {{--
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Способы оплаты заказа</h3>
                    </div>
                    <form action="{{ route('admin.variable.save') }}" method="POST">
                        <div class="box-body">
                            @csrf
                            --}}{{--<input type="hidden" name="group" value="prices">--}}{{--
                            <input type="hidden" name="destination" value="{{ Request::fullUrl() }}">
                            <input type="hidden" name="locale" value="{{ $locale }}">

                            @include('admin.fields.field-links', [
                               'label' => 'Способы оплаты',
                               'field_name' => 'vars_json[payment_methods]',
                               'key_key' => 'key',
                               'key_value' => 'value',
                               'placeholder_key' => 'Ключ',
                               'placeholder_value' => 'Значение',
                               'items' => json_decode(variable('payment_methods', '[]', $locale), true),
                           ])
                        </div>
                        <div class="box-footer">
                            @include('admin.fields.field-form-buttons')
                        </div>
                    </form>
                </div>

--}}
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Блок с иконками на картке товара</h3>
                    </div>
                    <form action="{{ route('admin.variable.save') }}" method="POST">
                        <div class="box-body">
                            @csrf
                            {{--<input type="hidden" name="group" value="prices">--}}
                            <input type="hidden" name="destination" value="{{ Request::fullUrl() }}">
                            <input type="hidden" name="locale" value="{{ $locale }}">

                            @include('admin.fields.field-links', [
                               'label' => 'Заголовок/Текст при наведении',
                               'field_name' => 'vars_json[product_cart_icons]',
                               'key_key' => 'key',
                               'key_value' => 'value',
                               'placeholder_key' => 'Ключ',
                               'placeholder_value' => 'Значение',
                               'items' => json_decode(variable('product_cart_icons', '[]', $locale), true),
                           ])

                        </div>
                        <div class="box-footer">
                            @include('admin.fields.field-form-buttons')
                        </div>
                    </form>
                </div>


            </div>
            <div class="col-md-6">

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация для типа доставки "Новая почта"</h3>
                    </div>
                    <form action="{{ route('admin.variable.save') }}" method="POST">
                        <div class="box-body">
                            @csrf
                            <input type="hidden" name="destination" value="{{ Request::fullUrl() }}">
                            <input type="hidden" name="locale" value="{{ $locale }}">

                            <div class="form-group {{ $errors->has('vars.delivery_novaposhta_price') ? 'has-error' : ''}}">
                                <label for="vars.delivery_novaposhta_price">Стоимость доставки "Новая почта"</label>
                                <input type="number" class="form-control" name="vars[delivery_novaposhta_price]" value="{{ variable('delivery_novaposhta_price', 0, $locale) }}">
                                {!! $errors->first('vars.delivery_novaposhta_price', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('vars.delivery_novaposhta_courier_desc') ? 'has-error' : ''}}">
                                <label for="vars.delivery_novaposhta_courier_desc">Описание "Новая почта" для "Курьер"</label>
                                <input type="text" class="form-control" name="vars[delivery_novaposhta_courier_desc]" value="{{ variable('delivery_novaposhta_courier_desc', '', $locale) }}">
                                {!! $errors->first('vars.delivery_novaposhta_courier_desc', '<p class="help-block">:message</p>') !!}
                            </div>

                        </div>
                        <div class="box-footer">
                            @include('admin.fields.field-form-buttons')
                        </div>
                    </form>
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Информация для типа доставки "Самовывоз из магазина"</h3>
                    </div>
                    <form action="{{ route('admin.variable.save') }}" method="POST">
                        <div class="box-body">
                            @csrf
                            {{--<input type="hidden" name="group" value="prices">--}}
                            <input type="hidden" name="destination" value="{{ Request::fullUrl() }}">
                            <input type="hidden" name="locale" value="{{ $locale }}">

                            <div class="form-group {{ $errors->has('vars.delivery_pickup_address') ? 'has-error' : ''}}">
                                <label for="vars.delivery_pickup_address">Адрес</label>
                                <input type="text" class="form-control" name="vars[delivery_pickup_address]" value="{{ variable('delivery_pickup_address', '', $locale) }}">
                                {!! $errors->first('vars.delivery_pickup_address', '<p class="help-block">:message</p>') !!}
                            </div>

                        </div>
                        <div class="box-footer">
                            @include('admin.fields.field-form-buttons')
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
