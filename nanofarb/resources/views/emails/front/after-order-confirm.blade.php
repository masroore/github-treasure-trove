@extends('emails.layouts')

{{-- После оформления заказа --}}

@section('content')
    <h2>Спасибо за ваш заказ!</h2>
    <p>Наш менеджер свяжется с вами в ближайшее время.</p>

    <p><b>Номер заказа:</b> {{ $order->number }}</p>

    <table cellspacing="2" border="1" cellpadding="5" width="100%">
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
                <td>{{ Currency::format($product->pivot->price * $product->pivot->quantity, 'UAH') }}</td>
            </tr>
        @endforeach
    </table>

    <p><b>Сумма заказа:</b> {{ Currency::format($order->price, 'UAH') }}</p>
    <p><b>Доставка:</b> {{ Currency::format($order->data['purchase']['delivery'] ?? 0, 'UAH') }}</p>
    <p><b>Скидка:</b> {{ Currency::format($order->data['purchase']['discount'] ?? 0, 'UAH') }}</p>
    <p><b>Сумма к оплате:</b> {{ Currency::format($order->price + ($order->data['purchase']['delivery'] ?? 0) - ($order->data['purchase']['discount'] ?? 0), 'UAH') }}</p>

    <p><b>Метод доставки:</b> {{ $order->getDeliveryMethodStr() }}</p>
    <p><b>Адрес доставки:</b> {{ $order->getDeliveryAddressStr() }}</p>

    <br>
    <p align="center">&copy; {{ date('Y') }} {{ link_to(config('app.url'), config('app.name')) }}</p>
@stop