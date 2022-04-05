<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Заказ #{{ $order->number }}
                <small class="pull-right">Оформлено: {{ optional($order->ordered_at)->format('d.m.Y h:i') ?? optional($order->created_at)->format('d.m.Y h:i') }}</small>
            </h2>
        </div>
    </div>


    <div class="row invoice-info">
        @if($order->user)
        <div class="col-sm-4 invoice-col">
            <div class="form-group">
                {!! Form::label('id', 'User ID', ['class' => 'control-label']) !!}
                {!! Form::text('id', $order->user->id, ['class' => 'form-control', 'readonly']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('name', 'ФИО', ['class' => 'control-label']) !!}
                {!! Form::text('name', $order->user->full_name, ['class' => 'form-control', 'readonly']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('created_at', 'Зарегистрирован', ['class' => 'control-label']) !!}
                {!! Form::text('created_at', $order->user->created_at, ['class' => 'form-control', 'readonly']) !!}
            </div>
        </div>
        @endif
        <div class="col-sm-4 invoice-col">
            <div class="form-group">
                {!! Form::label('phone', 'Телефон', ['class' => 'control-label']) !!}
                {!! Form::text('phone', $order->user ? $order->user->phone : $order->data["delivery"]["phone"], ['class' => 'form-control', 'readonly']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                {!! Form::text('email', $order->user ? $order->user->email : $order->data["delivery"]["email"], ['class' => 'form-control', 'readonly']) !!}
            </div>
{{--
            <div class="form-group {{ $errors->has('moder_comment') ? 'has-error' : ''}}">
                {!! Form::label('moder_comment', 'Комментарий менеджера', ['class' => 'control-label']) !!}
                {!! Form::textarea('moder_comment', $order->moder_comment, ['class' => 'form-control', 'rows' => 8, 'cols' => 20]) !!}
                {!! $errors->first('moder_comment', '<p class="help-block">:message</p>') !!}
            </div>
            --}}
        </div>
        <div class="col-sm-4 invoice-col">
            @include('admin.fields.field-select2-static', [
                'label' => 'Статус заказа',
                'field_name' => 'status',
                'attributes' => \App\Models\Taxonomy\Term::byVocabulary('order_statuses')->pluck('name', 'system_name')->toArray(),
                'selected' => isset($order) ? $order->status : [],
            ])

            @include('admin.fields.field-select2-static', [
                'label' => 'Статус оплаты заказа',
                'field_name' => 'payment_status',
                'attributes' => \App\Models\Taxonomy\Term::byVocabulary('payment_statuses')->pluck('name', 'system_name')->toArray(),
                'selected' => isset($order) ? $order->payment_status : [],
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                {!! Form::label('comment', 'Комментарий', ['class' => 'control-label']) !!}
                {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 5,]) !!}
                {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Данные для доставки</h3>
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <div class="form-group {{ $errors->has('data.payment.method') ? 'has-error' : ''}}">
                {!! Form::label('data[payment][method]', 'Тип оплаты', ['class' => 'control-label']) !!}
                {!! Form::select('data[payment][method]', ['' => '---'] + \App\Models\Shop\Order::getPaymentMethods(), $order->data['payment']['method'] ?? '', ['class' => 'form-control  select2', 'data-minimum-results-for-search' => '-1']) !!}
                {!! $errors->first('data.payment.method', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('data.delivery.method') ? 'has-error' : ''}}">
                {!! Form::label('data[[delivery][method]', 'Метод доставки', ['class' => 'control-label']) !!}
                {!! Form::select('data[delivery][method]', \App\Models\Shop\Order::$deliveryMethods, $order->data['delivery']['method'] ?? '', ['class' => 'form-control  select2', 'data-minimum-results-for-search' => '-1']) !!}
                {!! $errors->first('data.delivery.method', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('data.delivery.tariff') ? 'has-error' : ''}}">
                {!! Form::label('data[delivery][tariff]', 'Тип/Тариф (Новая почта)', ['class' => 'control-label']) !!}
                {!! Form::select('data[delivery][tariff]', ['' => '---', 'pvz' => 'Доставка до пункта выдачи заказов', 'courier' => 'Курьер'], $order->data['delivery']['tariff'] ?? '', ['class' => 'form-control  select2', 'data-minimum-results-for-search' => '-1']) !!}
                {!! $errors->first('data.delivery.tariff', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('data.delivery.pvz') ? 'has-error' : ''}}">
                {!! Form::label('data[delivery][pvz]', '№ Пункта выдачи заказов', ['class' => 'control-label']) !!}
                {!! Form::number('data[delivery][pvz]', $order->data['delivery']['pvz'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.pvz', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-sm-4 invoice-col">
            <div class="form-group {{ $errors->has('data.delivery.name') ? 'has-error' : ''}}">
                {!! Form::label('data[delivery][name]', 'ФИО', ['class' => 'control-label']) !!}
                {!! Form::text('data[delivery][name]', $order->data['delivery']['name'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.name', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('data.delivery.phone') ? 'has-error' : ''}}">
                {!! Form::label('data[delivery][phone]', 'Телефон', ['class' => 'control-label']) !!}
                {!! Form::text('data[delivery][phone]', $order->data['delivery']['phone'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.phone', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('data.delivery.email') ? 'has-error' : ''}}">
                {!! Form::label('data[delivery][email]', 'Email', ['class' => 'control-label']) !!}
                {!! Form::text('data[delivery][email]', $order->data['delivery']['email'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-sm-4 invoice-col">
            <div class="form-group {{ $errors->has('data.delivery.city') ? 'has-error' : ''}}">
                {!! Form::label('city', 'Город', ['class' => 'control-label']) !!}
                {!! Form::text('data[delivery][city]', $order->data['delivery']['city'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.city', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('data.delivery.region') ? 'has-error' : ''}}">
                {!! Form::label('region', 'Регион, область', ['class' => 'control-label']) !!}
                {!! Form::text('data[delivery][region]', $order->data['delivery']['region'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.region', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('data.delivery.zip_code') ? 'has-error' : ''}}">
                {!! Form::label('zip_code', 'Индекс', ['class' => 'control-label']) !!}
                {!! Form::text('data[delivery][zip_code]', $order->data['delivery']['zip_code'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.zip_code', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('data.delivery.address') ? 'has-error' : ''}}">
                {!! Form::label('address', 'Адрес', ['class' => 'control-label']) !!}
                {!! Form::text('data[delivery][address]', $order->data['delivery']['address'] ?? '', ['class' => 'form-control']) !!}
                {!! $errors->first('data.delivery.address', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive">
            @if($order->products->count())
            <h3>Товары заказа ({{ $order->products->count() }})</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>SKU</th>
                    <th>Название</th>
                    <th>Значение цвета (Название)</th>
                    <th>Цвет</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->color_name }}</td>
                        <td><span style="width: 40px; display: block; height: 20px; border-radius: 5px; background:{{'#'.$product->color}} "></span></td>
                        <td>
                            {{ Currency::format($product->pivot->price) }}
                        </td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>
                            {{ Currency::format($product->pivot->price * $product->pivot->quantity) }}
                        </td>
                        <td style="width: 30px">
                            <div class="btn-group">
                                <a href="{{ route_alias('products.show', $product) }}" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                <a href="#" data-url="{{ route('admin.orders.product.destroy', [$order, $product]) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <h3 class="text-warning">Товаров в заказе пока нет :(</h3>
            @endif
        </div>
    </div>

    @isset($order->data['sales'])
        @if(count($order->data['sales']))
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <h3>Примененные акции и скидки</h3>
                {{--{!! var_dump($order->data['sales']) !!}--}}
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Тип</th>
                        <th>Скидка</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->data['sales'] ?? []  as $sale)
                        <tr>
                            <td>{{ $sale['id'] }}</td>
                            <td>{{ $sale['name'] }}</td>
                            <td>{{ \App\Models\Shop\Sale::$types[$sale['type']] ?? '' }}</td>
                            <td>@if($sale['discount_type'] == \App\Models\Shop\Sale::DISCOUNT_TYPE_SUM){{ Currency::format($sale['discount'] ?? 0) }}@else {{$sale['discount'] ?? 0}}% @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        @endif
    @endisset

    <div class="row">
        <div class="col-xs-12">
            <h3>Суммы</h3>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">За товары:</th>
                        <td>{{ Currency::format($order->price + $order->getCalculateDiscount('discount_products')) }}</td>
                    </tr>
                    <tr>
                        <th>Скидка:</th>
                        <td>{{ Currency::format($order->getCalculateDiscount()) }}</td>
                    </tr>
                    <tr>
                        <th>Доставка:</th>
                        <td>{{ Currency::format($order->data['purchase']['delivery'] ?? 0) }}</td>
                    </tr>
                    <tr>
                        <th>К оплате:</th>
                        <td>{{ Currency::format($order->price + ($order->data['purchase']['delivery'] ?? 0) - ($order->data['purchase']['discount'] ?? 0)) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-xs-12">
            <a
               href="{{ route('admin.orders.print', $order) }}"
               target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Печать
            </a>
            @include('admin.fields.field-form-buttons', [
                'url_store_and_close' => session('admin.orders.index'),
                'url_close' => session('admin.orders.index'),
            ])
        </div>
    </div>
</section>
