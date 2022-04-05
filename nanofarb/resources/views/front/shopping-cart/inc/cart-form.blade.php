{{--<div class="basket-content">--}}
{{--@dd($cart['products'])--}}

@if(count($cart['products']) > 0)

    <form action="{{ route('shopping-cart.order') }}"
          method="POST"
          data-id="cart-form"
          class="js-ajax-form-submit"
          id="cart-form"
          data-seo-action="order_success_cart_page"
    >
        <input type="hidden" name="locale" value="{{ \UrlAliasLocalization::getCurrentLocale() }}">

        <div class="basket-content__wrapper">

            <div class="basket-content__left">

                {{-- Товары в корзине --}}
{{--                @dd($cart['products'])--}}
                @foreach($cart['products'] as $product)
                    <div class="basket-content__left-block">
                        <input id="product-id" data-product-id="{{$product["id"]}}" type="hidden">
                        <div class="basket-content__left-img">
                            <a href="{{ route('product.show', $product) }}" class="basket-content__left-img">
                                <img src="{{ $product->getFirstMediaUrl('images', 'cart-page') ?: '/its-client/img/product.png' }}" alt="{{ $product["name"] }}">
                            </a>
                        </div>
                        <div class="basket-content__left-info">
                            <div class="basket-content__left-head">
                                <a href="{{ route('product.show', $product) }}">
                                <h2>
                                    {{ $product->name }}
                                </h2>
                                </a>
                                <button>
                                <span class="js-remove-product js-ajax-cart-product-remove"
                                      data-url="{{ route('shopping-cart.form') }}"
                                      data-html-container="#cart-page-content"
                                >
                                    <svg class="icon-svg icon-svg-close color-red"><use xlink:href="/its-client/img/sprite.svg#close"></use></svg>
                                </span>
                                </button>
                            </div>
                            <p>{{ optional($product->txCategory)->name }}</p>
                            <p>{{ trans('site.Арт.') }}: {{{ $product->sku }}}</p>
                            <p class="color-product-current">{{ trans('site.Цвет') }}: <span style="background:{{'#'.$product->color}} "></span></p>
                            <div class="basket-content__left-bottom">
                                <div class="basket-content__left-price">
                                    @php
                                            //$price = $product->getCalculatePrice('price');

                                            $price = $product->pivot->price;
                                                //foreach(session('cart') as $sessionProductId => $sessionProduct)
                                                    //{
                                                        //if ($product->id === $sessionProductId)
                                                            //{
                                                            //    $price = $sessionProduct['price'];
                                                          //  }
                                                        //else {
                                                        //    $price = $product->getCalculatePrice('price');
                                                      //  }
                                                    //}

                                    @endphp
                                    {{ Currency::format($price, $product->currency) }}
                                    <div class="price-convert">({{ Currency::getConvertsStr($price, $product->currency) }})</div>
                                </div>
                                <div class="basket-content__left-quantity">
                                    <button class="less js-set-amount js-ajax-cart-form-submit" data-addition="-1" data-url="{{ route('shopping-cart.form') }}" data-html-container="#cart-page-content">-</button>
                                    <input type="text" class="amount-product" value="{{ $product->pivot->quantity }}" readonly name="products[{{$product->id}}][amount]">
                                    <span type="hidden" class="hide product-id-color" data-quantity="{{ $product->pivot->quantity }}" data-color-value="{{$product->pivot->value_id}}"></span>
                                    <button class="more js-set-amount js-ajax-cart-form-submit" data-addition="1" data-url="{{ route('shopping-cart.form') }}" data-html-container="#cart-page-content">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="basket-content__right">
                <div class="basket-content__right-block">
                    <div class="basket-content__right-name">
                        {{ trans('site.Оформление заказа') }}
                    </div>
                    <div class="basket-content__right-form">
                        @auth
                        <div class="form-group">
                            <label>{{ trans('site.Телефон') }}</label>
                            <input class="input phone" id="client-phone" type="text" placeholder="{{ config('web-forms.phone.placeholder') }}" data-mask="{{ config('web-forms.phone.mask') }}" data-mask-clearifnotmatch="true"  name="data[delivery][phone]" value="{{ request('data.delivery.phone', Auth::user()->phone) }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('site.E-mail') }}</label>
                            <input class="input" type="email" name="data[delivery][email]" value="{{ request('data.delivery.email', Auth::user()->email) }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('site.Имя') }}</label>
                            <input class="input" type="text" name="data[delivery][name]" value="{{ request('data.delivery.name', Auth::user()->full_name) }}">
                        </div>
                        @else
                        <div class="form-group">
                            <label>{{ trans('site.Телефон') }}</label>
                            <input class="input phone" id="client-phone" type="text" placeholder="{{ config('web-forms.phone.placeholder') }}" data-mask="{{ config('web-forms.phone.mask') }}" data-mask-clearifnotmatch="true" name="data[delivery][phone]" value="{{ request('data.delivery.phone') }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('site.E-mail') }}</label>
                            <input class="input" type="email" name="data[delivery][email]" value="{{ request('data.delivery.email') }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('site.Имя') }}</label>
                            <input class="input" type="text" name="data[delivery][name]" value="{{ request('data.delivery.name') }}">
                        </div>
                        @endauth
                    </div>
                </div>
                <div class="basket-content__right-block">
                    <div class="basket-content__right-name">
                        {{ trans('site.Доставка') }}
                    </div>
                    <div class="basket-content__right-form">
                        <div class="form-group">
                            <div class="radio-group">
                                <label>
                                    <span class="label">{{ trans('site.Новая Почта') }} </span>
                                    <input class="radio js-select-delivery-method" type="radio" name="data[delivery][method]" value="novaposhta" @if(request('data.delivery.method', 'novaposhta') == 'novaposhta') checked @endif>
                                    <span class="radio-custom"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-group">
                                <label>
                                    <span class="label">{{ trans('site.Самовывоз') }}</span>
                                    <input class="radio js-select-delivery-method" type="radio" name="data[delivery][method]" value="pickup" @if(request('data.delivery.method') == 'pickup') checked @endif>
                                    <span class="radio-custom"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @if(request('data.delivery.method', 'novaposhta') == 'novaposhta')
                    <div class="basket-content__right-form basket-content__right-form_inner">
                        <div class="form-group">
                            <div class="radio-group">
                                <label>
                                    <span class="label">{{ trans('site.В отделения') }}</span>
                                    <input class="radio js-select-delivery-tariff" type="radio" name="data[delivery][tariff]" value="pvz" @if(request('data.delivery.tariff', 'pvz') == 'pvz') checked @endif>
                                    <span class="radio-custom"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-group">
                                <label>
                                    <span class="label">{{ trans('site.Курьер') }}</span>
                                    <input class="radio js-select-delivery-tariff" type="radio" name="data[delivery][tariff]" value="courier" @if(request('data.delivery.tariff') == 'courier') checked @endif>
                                    <span class="radio-custom"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="basket-content__right-name">
                        <span>{{ trans('site.Адрес доставки') }}</span>
                    </div>
                    <div class="basket-content__right-form basket-content__right-form_input">
                        <div class="form-group">
                            <label>
                                {{{ trans('site.Город') }}}
                            </label>

                            <input type="text" class="input" name="data[delivery][city]" value="{{ request('data.delivery.city') }}">
                            {{--
                            <select class="select-filter" id="delivery" name="data[delivery][city]" value="{{ request('data.delivery.city') }}">
                                <option></option>
                                <option value="По популярности">Сначала дешевле</option>
                                <option value="По цене">Сначала дороже</option>
                                <option value="По цене">По названию</option>
                                <option value="По цене">По новизне </option>
                                <option value="По цене">По количеству</option>
                            </select>
                            --}}
                        </div>
                        <div class="form-group">
                            <label>
                                {{ trans('site.Отделение') }}
                            </label>
                            <input type="number" class="input" min="1" max="500" name="data[delivery][pvz]" value="{{ request('data.delivery.pvz') }}">
                        </div>
                    </div>
                        @if(request('data.delivery.tariff') == 'courier')
                            <div class="basket-content__right-name">
                                <span>{!! variable('delivery_novaposhta_courier_desc') !!}</span>
                            </div>
                        @endif
                    @elseif(request('data.delivery.method') == 'pickup')
                        @if($address = variable('delivery_pickup_address'))
                        <div class="basket-content__right-name">
                            <span> <strong> {{ trans('site.Адрес') }}:</strong>  {!! $address !!}</span>
                        </div>
                        @endif
                    @endif
                </div>
                <div class="basket-content__right-block">
                    <div class="basket-content__right-name">
                        {{ trans('site.Тип оплаты') }}
                    </div>
                    <div class="basket-content__right-form">
                        @foreach(\App\Models\Shop\Order::getPaymentMethods() as $key => $item)
                        <div class="form-group">
                            <div class="radio-group">
                                <label>
                                    <span class="label">{{ $item }}</span>
                                    <input class="radio" type="radio" name="data[payment][method]" value="{{ $key }}" @if((request('data.payment.method') === $key) || empty(request('data.payment.method')) && $loop->first) checked @endif>
                                    <span class="radio-custom"></span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="basket-content__right-block">
                    <div class="basket-content__right-group">
                        <div class="basket-content__right-text">
                            <p>{{ trans('site.Товары') }}</p>
                            <p>{{ trans('site.Доставка') }}</p>
                            <p>{{ trans('site.Скидка') }} </p>
                            <p>{{ trans('site.Всего') }}</p>
                        </div>
                        <div class="basket-content__right-text basket-content__right-text_1">
                            <p>{{ Currency::format($purchase['products']) }} <span class="price-convert">({{ Currency::getConvertsStr($purchase['products'], 'UAH') }})</span></p>
                            {{--<p>{{ Currency::format($purchase['delivery']) }}</p>--}}
                            <p>{{ trans('site.По тарифам службы доставки') }}</p>
                            <p>{{ Currency::format($purchase['discount'] + $purchase['discount_products']) }} <span class="price-convert">({{ Currency::getConvertsStr($purchase['discount'] + $purchase['discount_products'], 'UAH') }})</span></p>
                            <p>{{ Currency::format($purchase['total']) }} <span class="price-convert">({{ Currency::getConvertsStr($purchase['total'], 'UAH') }})</span></p>
                        </div>
                    </div>
                    <input type="hidden"
                           class="js-ajax-cart-form-submit"
                           id="reload-cart-page"
                           data-html-container="#cart-page-content"
                           data-url="{{ route('shopping-cart.form') }}"
                    >
                    <button class="btn-gen"
                            type="submit"
                    >{{ trans('site.Оформить заказ') }}</button>
                </div>
            </div>
        </div>
    </form>
@else
    <div class="basket__head-text">
        {{ trans('site.В вашей корзине пока что нет товаров') }} :(
    </div>
@endif
{{--</div>--}}