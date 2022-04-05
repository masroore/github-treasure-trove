<div class="card-product__head-left">
    <div class="card-product__head-img">
        <img class="big" src="{{ $product->getFirstMediaUrl('images', 'card-product') ?: '/its-client/img/card-product.png' }}" alt="{{ $product->name }}">
        {{--                        <img class="big" src="/its-client/img/card-product.png" alt="{{ $product->name }}">--}}
    </div>

    {{--
    <div class="small">
        <img src="/its-client/img/card-product-bot.png" alt="">
    </div>
    --}}
    <div class="card-product__head-docs">
        <a target="_blank" href="{{$product->getFirstMediaUrl('specification') ?: \Illuminate\Support\Facades\Storage::disk('public')->url(variable('file_catalog'))}}">{{trans('site.Спецификация')}}</a>
        <a target="_blank" href="{{\Illuminate\Support\Facades\Storage::disk('public')->url(variable('file_catalog'))}}">Katalog Nanofarb PDF</a>
        <a href="{{config('services.gruntovki')}}" class="card-product__head-grunt">
            <img src="/its-client/img/vedro.png" alt="">
            <span>Не забудьте купить грунтовку</span>
        </a>
    </div>
</div>
<div class="card-product__head-right">
    <h1 class="card-product__head-name">{{ $product->name }}</h1>
    <div class="card-product__head-block">
        <div class="card-product__head-star">
            @for($i = 1; $i < 6; $i++)
                @if($product->getReviewsRating() >= $i)
                    <img src="/its-client/img/Star.png" alt="{{$i}}">
                @else
                    <img src="/its-client/img/Star-off.png" alt="{{$i}}">
                @endif
            @endfor
        </div>
        <div class="card-product__head-text">{{ trans('site.Арт.') }} {{ $product->sku }}</div>
        @if($reviews->count())
            <div class="card-product__head-text">({{ trans('site.Оценило') }} {{ $reviews->count() }} {{ trans_choice('site.пользователь', $reviews->count()) }})</div>
        @endif
    </div>
    <div class="card-product__head-content wrapper-to-options">
        {{--                        <input type="hidden" id="product-session-id" data-update-cart="{{route('shopping-cart.update')}}" data-id="{{$product->id}}">--}}
        <div class="card-product__content-head">
            <div class="quantity">
                <button class="less js-change-count" data-url="{{route('product.update-count')}}" data-product-id="{{$product->id}}" data-html-container=".card-product__head" data-add="-1">-</button>
                <input type="text" value="1" id="quantity-prod">
                <button class="more js-change-count" data-url="{{route('product.update-count')}}" data-product-id="{{$product->id}}" data-html-container=".card-product__head" data-add="1">+</button>
            </div>
            @if($product->getCalculatePrice('sale'))
                <div class="clock" data-date="{{ $product->getCalculatePrice('sale')->end_at->format('Y/m/d H:j') }}" id="clock"></div>
            @endif
            <div class="card-product__content-price">
                @php
                    $price = $product->getCalculatePrice('price');
                @endphp
                <div class="price-block">
                    <p class="js-product-price" data-current-price="{{ Currency::format($price) }}" data-price="{{ Currency::format($price) }}" data-price-value="{{$price}}" data-basic-price="{{ Currency::format($price) }}">
                        @if ($priceColor)
                            {{$priceColor}}
                        @else
                            {{ Currency::format($price) }}
                        @endif
                    </p>
                    @if ($priceColorCurrent)
                        <span class="price-convert">({{ $priceColorCurrent }})</span>
                    @else
                        <span class="price-convert">({{ Currency::getConvertsStr($price, $product->currency) }})</span>
                    @endif
                </div>

                @if ($priceColorOld)
                    <span class="price-old">{{ $priceColorOld }}</span>
                @else
                    @if($priceOldCalc = $product->getCalculatePrice('price_old'))<span class="price-old">{{ Currency::format($priceOldCalc)  }}</span>@endif
                @endif


            </div>
        </div>
        <div class="card-product__content-bottom">
            @foreach($product->attrsGroups() as $key => $value)
                <a class="card-product__content-size js-product-choice @if($product->id === $key) active @endif" data-product-id="{{$key}}" data-html-container=".card-product__head"  href="{{ route_alias('product.show', $value["link"]) }}">{{$value["value"]}}{{$value["suffix"]}}</a>
            @endforeach
        </div>
    </div>
    @if($tining->isNotEmpty())

        <div class="card-product__head-content color-block">
            <button type="button"  data-product-id="{{$product->id}}" class="btn-gen btn-tinting js-button-color">{{trans('site.Колеровка')}}</button>
            <div class="color-block__choice color-block-wrapper"></div>
        </div>
    @endif
    <div class="card-product__head-button">
        <button type="button" data-html-container=".js-cart-in-header" data-color-id="" data-product-id="{{$product->id}}" class="btn-gen js-add-to-cart">{{ trans('site.В корзину') }}</button>
        {{--                        <button class="btn-gen js-action-click2 buy-action" id="click-add-card"--}}
        {{--                                data-url="{{ route('shopping-cart.add', $product) }}"--}}
        {{--                                data-data='{"color_id": ""}'--}}
        {{--                                data-html-container=".cart-in-header"--}}
        {{--                                data-seo-action="click_bue_product_page"--}}
        {{--                                --}}{{--data-seo-label="{{ $product->sku }}"--}}
        {{--                        >{{ trans('site.В корзину') }}</button>--}}
        <button class="btn-gen btn-gen js-seo-click js-btn-bue-one-click" data-seo-action="quick_order_button_click" data-product-id="{{ $product->id }}">{{ trans('site.Заказать сейчас') }}</button>
    </div>
    @php
        $icons = json_decode(variable('product_cart_icons', '[]', \UrlAliasLocalization::getCurrentLocale()), true);
    @endphp
    <div class="card-product__head-info">
        <div class="block">
            <div class="block-repeat">
                <div class="img">
                    <img src="/its-client/img/delivery.png" alt="">
                </div>
                <p>{!! $icons[0]['key'] ?? 'Доставка по всей России' !!}</p>
            </div>
            <div class="block-hide">
                <span>{!! $icons[0]['value'] ?? 'Доставка по всей России - описание' !!}</span>
            </div>
        </div>
        <div class="block">
            <div class="block-repeat">
                <div class="img">
                    <img src="/its-client/img/garant.png" alt="">
                </div>
                <p>{!! $icons[1]['key'] ?? 'Гарантия кочества' !!}</p>
                <div class="block-hide">
                    <span>{!! $icons[1]['value'] ?? 'Гарантия качества - описание' !!}</span>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-repeat">
                <div class="img">
                    <img src="/its-client/img/card-3.png" alt="">
                </div>
                <p>{!! $icons[2]['key'] ?? 'Возврат в течении 14 дней' !!}</p>
                <div class="block-hide">
                    <span>{!! $icons[2]['value'] ?? 'Возврат в течении 14 дней - описание' !!}</span>
                </div>
            </div>
        </div>
    </div>
</div>