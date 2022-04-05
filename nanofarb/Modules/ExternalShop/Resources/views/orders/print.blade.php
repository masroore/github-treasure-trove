@include('admin.layouts.begin-print')
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
                <h3>Клиент</h3>
                <address>
                    <strong>ФИО: </strong>{{ $order->client['fullname'] }}<br>
                    <strong>Телефон: </strong>{{ $order->client['phone'] }}<br>
                    <strong>Email: </strong>{{ $order->client['email'] }}
                </address>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <h3>Данные заказа</h3>
                <address>
                    <strong>Способ доставки: </strong>{{ $order->delivery_service }}<br>
                    <strong>Адрес доставки: </strong>{{ $order->delivery_address }}<br>
                    <strong>Инфо об плате: </strong>{{ $order->payment_info }}<br>
                    <strong>Статус заказа: </strong>{!! $order->getStatusStr('lte_title')  !!}<br>
                </address>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <h3>Товары</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>SKU</th>
                        <th style="width: 50%">Название товара</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order['purchases'] as $purchases)
                        <tr>
                            <td>{{ $purchases['sku'] }}</td>
                            <td>{{ $purchases['name'] }}</td>
                            <td>{{ Currency::format($purchases['price']) }}</td>
                            <td>{{ $purchases['quantity'] }}</td>
                            <td>{{ Currency::format($purchases['price'] * $purchases['quantity']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-sm-4 invoice-col">
            <strong>Коментарий клиента:</strong>
            <p>
                {{ $order->client_comment ?? '-' }}
            </p>
            <strong>Коментарий продавца:</strong>
            <p>
                {{ $order->seller_comment ?? '-' }}
            </p>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h3>Суммы</h3>
                <div class="table-responsive">
                    <table class="table">
                    <tr>
                        <th>К оплате:</th>
                        <td>{{ Currency::format($order->total_sum) }}</td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="#" onclick="window.print();" class="btn btn-default"><i class="fa fa-print"></i> Печать</a>
            </div>
        </div>
    </section>
@include('admin.layouts.inc.end-print')