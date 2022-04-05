@extends('externalshop::mails.app')

{{-- После подтверждение (оформления) заказа --}}

@section('content')
    <h2>Новый заказ ({{ $order->source }})</h2>

    <p><b>Оформлено:</b> {{ $order->confirmed_at }}</p>
    <p><b>ФИО:</b> {{ $order->client['fullname'] ?? '' }}</p>
    <p><b>Телефон:</b> {{ $order->client['phone'] ?? '' }}</p>
    <p><b>Email:</b> {{ $order->client['email'] ?? '' }}</p>

    <hr>

    <p><b>Номер заказа:</b> {{ $order->number }}</p>
    <p><b>Способ доставки: </b>{{ $order->delivery_service }}</p>
    <p><b>Адрес доставки: </b>{{ $order->delivery_address }}</p>
    <p><b>Инфо об плате: </b>{{ $order->payment_info }}</p>
    <p><b>Статус заказа: </b>{!! $order->getStatusStr()  !!}</p>

    <hr>

    <table class="wrapper" width="100%" cellspacing="2" border="1" cellpadding="5">
        <tr>
            <th>SKU</th>
            <th style="width: 50%">Товар</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
        </tr>
        @foreach($order['purchases'] as $purchases)
            <tr>
                <td>{{ $purchases['sku'] }}</td>
                <td>{{ $purchases['name'] }}</td>
                <td>{{ Currency::format($purchases['price']) }}</td>
                <td>{{ $purchases['quantity'] }}</td>
                <td>{{ Currency::format($purchases['price'] * $purchases['quantity']) }}</td>
            </tr>
        @endforeach
    </table>

    <div>
        <strong>Коментарий клиента:</strong>
        <p>
            {{ $order->client_comment ?? '' }}
        </p>
        <strong>Коментарий продавца:</strong>
        <p>
            {{ $order->seller_comment ?? '' }}
        </p>
    </div>

    <p><b>Сумма:</b> {{ Currency::format($order->total_sum) }}</p>
    <br>

    <p align="center">&copy; {{ date('Y') }} {{ link_to(config('app.url'), config('app.name')) }}</p>
@stop