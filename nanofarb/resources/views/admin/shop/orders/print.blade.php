@include('admin.layouts.begin-print')
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
            <div class="col-sm-4 invoice-col">
                <strong>Клиент</strong>
                <address>
                    <strong>ФИО: </strong>{{ $order->user->name }}<br>
                    <strong>Телефон: </strong>{{ $order->user->phone }}<br>
                    <strong>Email: </strong>{{ $order->user->email }}
                </address>
            </div>
            {{--
            <div class="col-sm-4 invoice-col">
                <strong>Коментарий к заказу</strong>
                <p>
                    {{ $order->comment }}
                </p>
            </div>
            --}}
        </div>

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <h3>Данные для доставки</h3>
                <address>
                    <strong>Тип оплаты: </strong>{{ $order->getPaymentMethodStr() }}<br>
                    <strong>Метод доставки: </strong>{{ $order->getDeliveryMethodStr() }}<br>
                    <strong>Тип/Тариф (Новая почта): </strong>{{ (['' => '---', 'pvz' => 'Доставка до пункта выдачи заказов', 'courier' => 'Курьер'])[$order->data['delivery']['tariff'] ?? ''] ?? '' }}<br>
                    <strong>№ Пункта выдачи заказов: </strong>{{ $order->data['delivery']['pvz'] ?? '' }}<br>
                    <hr>
                    <strong>ФИО: </strong>{{ $order->data['delivery']['name'] ?? '' }}<br>
                    <strong>Телефон: </strong>{{ $order->data['delivery']['phone'] ?? '' }}<br>
                    <strong>Email: </strong>{{ $order->data['delivery']['email'] ?? '' }}<br>
                    <strong>Город: </strong>{{ $order->data['delivery']['city'] ?? '' }}<br>
                    <strong>Регион, область: </strong>{{ $order->data['delivery']['region'] ?? '' }}<br>
                    <strong>Индекс: </strong>{{ $order->data['delivery']['zip_code'] ?? '' }}<br>
                    <strong>Адрес: </strong>{{ $order->data['delivery']['address'] ?? '' }}<br>
                </address>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <h3>Товары заказа</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Название товара</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>
                                {{ Currency::format($product->pivot->price, 'RUB') }}
                            </td>
                            <td>
                                {{ Currency::format($product->pivot->price * $product->pivot->quantity, 'RUB') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
                        <td>
                            {{ Currency::format($order->getCalculateDiscount()) }}
                        </td>
                    </tr>
                    <tr>
                        <th>К оплате:</th>
                        <td>{{ Currency::format($order->price) }}</td>
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
@include('admin.layouts.end-print')