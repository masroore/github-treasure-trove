@extends('emails.layouts')

{{-- После подтверждение (оформления) заказа --}}

@section('content')
    <h2>Новый заказ</h2>

    <p><b>Номер заказа:</b> {{ $order->number }}</p>

    <table class="wrapper" width="100%" cellspacing="2" border="1" cellpadding="5">
        <tr>
            <th>Артикул</th>
            <th>Товар</th>
            <th>Артикул</th>
            <th>Количество</th>
            <th>Сумма</th>
        </tr>
        @foreach($order->products as $product)
            <tr>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{!! $product->pivot->quantity !!}</td>
                <td>{{ Currency::format($product->pivot->price * $product->pivot->quantity, 'RUB') }}</td>
            </tr>
        @endforeach
    </table>

    <p><b>Сумма заказа:</b> {{ Currency::format($order->price) }}</p>
    <p><b>Доставка:</b> {{ Currency::format($order->data['purchase']['delivery'] ?? 0) }}</p>
    <p><b>Скидка:</b> {{ Currency::format($order->data['purchase']['discount'] ?? 0) }}</p>
    <p><b>Сумма к оплате:</b> {{ Currency::format($order->price + ($order->data['purchase']['delivery'] ?? 0) - ($order->data['purchase']['discount'] ?? 0)) }}</p>

    <p><b>Промокод:</b> {{ $order->data['sales']['promocode'] ?? '' }}</p>

    <p><b>ФИО:</b> {{ $order->data['delivery']['name'] ?? '' }}</p>
    <p><b>Телефон:</b> {{ $order->data['delivery']['phone'] ?? '' }}</p>
    <p><b>Email:</b> {{ $order->data['delivery']['email'] ?? '' }}</p>

    <p><b>Метод доставки:</b> {{ $order->getDeliveryMethodStr() }}</p>
    <p><b>Адрес доставки:</b> {{ $order->getDeliveryAddressStr() }}</p>
    <p><b>Тип оплаты:</b> {{ $order->getPaymentMethodStr() }}</p>
{{--
    @php($tariffs = ['' => '---', '136' => 'Доставка до пункта самовывоза (136)', '137' => 'Доставка "до двери" (137)'])
    <p><b>Отделение/Тариф:</b> {{ $tariffs[$order->data['delivery']['tariff'] ?? ''] ?? '' }}</p>
    --}}
    <p><b>Город:</b> {{ $order->data['delivery']['city'] ?? '' }}</p>

    <br>

    <p align="center">&copy; {{ date('Y') }} {{ link_to(config('app.url'), config('app.name')) }}</p>
@stop