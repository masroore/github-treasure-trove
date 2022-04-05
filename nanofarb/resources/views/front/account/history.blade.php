@extends('front.layouts.app')

@php
    MetaTag::setDefault(['title' => trans('site.История заказов')]);
    $localeboundAlternativeSegmentUrl = 'account/history';
@endphp

@section('content')
    <div class="personal personal_story">
        <div class="breadcrumb-repeat">
            {!! Breadcrumbs::render('home', 'История заказов') !!}
        </div>
        <div class="personal__wrapper">
            <h1 class="name-big">{{ trans('site.История заказов') }}</h1>
            <div class="personal__text">
                {{ trans('site.Здесь вы можете посмотреть истирию ваших заказов') }}
            </div>
            <div class="personal__nav">
                <ul>
                    <li><a href="{{ route_alias('account.edit') }}">{{ trans('site.Личные данные') }}</a></li>
                    <li class="active"><a href="{{ route_alias('account.history') }}">{{ trans('site.История заказов') }}</a></li>
                </ul>
            </div>
            <div class="story">
                <div class="story__wrapper">
                    @if($orders->count())
                    @foreach($orders as $order)
                        <div class="story__info">
                            <div class="story__info-group">
                                <div class="story__info-line">
                                    <div class="story__block">#{{$order->number}}</div>
                                    <div class="story__block">{{ $order->ordered_at->format('d.j.Y') }}</div>
                                    <div class="story__block">
                                        @php
                                            $price = $order->price + ($order->data['purchase']['delivery'] ?? 0) - ($order->data['purchase']['discount'] ?? 0)
                                        @endphp
                                        {{ Currency::format($price) }}
                                        <span class="price-convert">({{ Currency::getConvertsStr($price, 'UAH') }})</span>
                                    </div>
                                    <div class="story__block">{{ $order->getPaymentStatusStr() }}</div>
                                    <div class="story__block">{{ $order->getStatusStr() }}</div>
                                </div>
                                <div class="story__hide">
                                    @foreach($order->products as $product)
                                    <div class="story__hide-line">
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Товар') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                {{--<p><a href="{{ route('product.show', $product) }}">{{ str_limit($product->name, 30) }}</a></p>--}}
                                                <p>{{ str_limit($product->name, 30) }}</p>
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Количество') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>{{ $product->pivot->quantity }} {{ trans('site.шт') }}</p>
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Цена') }}: </p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>
                                                    {{ Currency::format($product->pivot->price) }}
                                                    <span class="price-convert">({{ Currency::getConvertsStr($product->pivot->price, $product->currency) }})</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="story__hide-line">
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Способ оплаты') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>{{ $order->getPaymentMethodStr() }}</p>
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Способ доставки') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>{{ $order->getDeliveryMethodStr() }}</p>
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Адрес доставки') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>{{ $order->getDeliveryAddressStr() }}</p>
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Статус оплаты') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>{{ $order->getPaymentStatusStr() }}</p>
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Статус заказа') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>{{ $order->getStatusStr() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="story__hide-line">
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Стоимость доставки') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>{{ trans('site.По тарифам службы доставки') }}</p>
{{--                                                <p>{{ Currency::format($order->data['purchase']['delivery'] ?? 0) }}</p>--}}
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Скидка') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>
                                                    {{ Currency::format($order->getCalculateDiscount()) }}
                                                    <span class="price-convert">({{ Currency::getConvertsStr($order->getCalculateDiscount(), 'UAH') }})</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="story__hide-group">
                                            <div class="story__hide-left">
                                                <p>{{ trans('site.Сумма к оплате') }}:</p>
                                            </div>
                                            <div class="story__hide-right">
                                                <p>
                                                    @php
                                                        $price = $order->price + ($order->data['purchase']['delivery'] ?? 0) - ($order->data['purchase']['discount'] ?? 0);
                                                    @endphp
                                                    {{ Currency::format($price) }}
                                                    <span class="price-convert">({{ Currency::getConvertsStr($price, 'UAH') }})</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <h3 style="text-align: center; margin: 30px auto;">{{ trans('site.Заказов пока еще нет') }} :(</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection