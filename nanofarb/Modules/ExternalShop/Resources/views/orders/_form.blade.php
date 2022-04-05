<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Заказ #{{ $order->number }}
                <small class="pull-right">Оформлено: {{ $order->confirmed_at }}</small>
            </h2>
        </div>
    </div>

    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <div class="form-group">
                {!! Form::label('client[fullname]', 'ФИО', ['class' => 'control-label']) !!}
                {!! Form::text('client[fullname]', $order->client['fullname'], ['class' => 'form-control',]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('client[phone]', 'Телефон', ['class' => 'control-label']) !!}
                {!! Form::text('client[phone]', $order->client['phone'], ['class' => 'form-control',]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('client[email]', 'Email', ['class' => 'control-label']) !!}
                {!! Form::text('client[email]', $order->client['email'], ['class' => 'form-control',]) !!}
            </div>
        </div>
        <div class="col-sm-4 invoice-col">
            <div class="form-group {{ $errors->has('delivery_service') ? 'has-error' : ''}}">
                {!! Form::label('delivery_service', 'Способ доставки', ['class' => 'control-label']) !!}
                {!! Form::text('delivery_service', $order->delivery_service, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group {{ $errors->has('delivery_address') ? 'has-error' : ''}}">
                {!! Form::label('delivery_address', 'Адрес доставки', ['class' => 'control-label']) !!}
                {!! Form::textarea('delivery_address', $order->delivery_address, ['class' => 'form-control', 'rows' => 2]) !!}
            </div>
        </div>
        <div class="col-sm-4 invoice-col">
            <div class="form-group {{ $errors->has('payment_info') ? 'has-error' : ''}}">
                {!! Form::label('payment_info', 'Инфо об оплате', ['class' => 'control-label']) !!}
                {!! Form::text('payment_info', $order->payment_info, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                {!! Form::label('status', 'Статуз заказа', ['class' => 'control-label']) !!}
                {!! Form::select('status', \Modules\ExternalShop\Entities\Order::getStatuses(), $order->status ?? '', ['class' => 'form-control  select2', 'data-minimum-results-for-search' => '-1']) !!}
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive">
            @if(isset($order['purchases']) && count($order['purchases']))
                <h3>Товары заказа ({{ count($order['purchases']) }})</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>SKU</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order['purchases'] as $purchase)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $purchase['img'] }}" style="max-height: 50px">
                            </td>
                            <td>{{ $purchase['sku'] }}</td>
                            <td>{{ $purchase['name'] }}</td>
                            <td>{{ Currency::format($purchase['price']) }}</td>
                            <td>{{ $purchase['quantity'] }}</td>
                            <td>{{ Currency::format($purchase['price'] * $purchase['quantity']) }}</td>
                            <td style="width: 30px">
                                <div class="btn-group">
                                    <a href="{{ $purchase['url'] }}" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
{{--                                    <a href="{{ route_alias('products.show', $product) }}" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>--}}
{{--                                    <a href="#" data-url="{{ route('admin.orders.product.destroy', [$order, $product]) }}" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>--}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-warning">Позиций в заказе нет :(</h3>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 invoice-col">
            <div class="form-group">
                {!! Form::label('client_comment', 'Комментарий клиента:', ['class' => 'control-label']) !!}
                {!! Form::textarea('client_comment', $order->client_comment, ['class' => 'form-control', 'rows' => 3, 'cols' => 20]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 invoice-col">
            <div class="form-group">
                {!! Form::label('seller_comment', 'Комментарий продавца:', ['class' => 'control-label']) !!}
                {!! Form::textarea('seller_comment', $order->seller_comment, ['class' => 'form-control', 'rows' => 3, 'cols' => 20]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h3>Суммы</h3>
            <div class="table-responsive">
                <table class="table">

                    <tr>
                        <th>К оплате:</th>
                        <td>{{ Currency::format($order['total_sum']) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-xs-12">
            <a
               href="{{ route('admin.externalshop.orders.print', $order) }}"
               target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Печать
            </a>
            @include('admin.fields.field-form-buttons', [
                //'url_store_and_close' => session('admin.externalshop.orders.index'),
                //'url_close' => session('admin.externalshop.orders.index'),
            ])
        </div>
    </div>
</section>
