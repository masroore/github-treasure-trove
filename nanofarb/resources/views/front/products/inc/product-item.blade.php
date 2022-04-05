<a href="{{ route_alias('product.show', $product) }}" class="item__head">
    <img class="big" src="{{ $product->getFirstMediaUrl('images', 'table') ?: '/its-client/img/product.png' }}" alt="{{ $product->name }}">
    <div class="rating">
        @for($i = 1; $i < 6; $i++)
            @if($product->getReviewsRating() >= $i)
                <img src="/its-client/img/Star.png" alt="{{$i}}">
            @else
                <img src="/its-client/img/Star-off.png" alt="{{$i}}">
            @endif
        @endfor
    </div>
</a>
<div class="item__info">
    <a href="{{ route_alias('product.show', $product) }}" class="item__info-name">
        {{ $product->name }}
    </a>
    <div class="item__info-options wrapper-to-options">
        <div class="card-product__content-head">
            <div class="quantity">
                <button class="less js-plus-prod" data-add="-1">-</button>
                <input type="text" value="1" id="quantity-prod">
                <button class="more js-plus-prod" data-add="1">+</button>
            </div>
        </div>

        <div class="item__info-price">
            @php
                $price = $product->getCalculatePrice('price');
            @endphp
            <p class="js-product-price" data-current-price="{{ Currency::format($price) }}" data-price="{{ Currency::format($price) }}" data-price-value="{{$price}}" data-basic-price="{{ Currency::format($price) }}">{{ Currency::format($price) }}</p>
        </div>
        <div class="item__info-size">
            <form>
                <input type="hidden" class="js-product-quantity" value="1">
                <input type="hidden" class="js-product-color" value="">
                <div class="product-choice-checkbox">
                    @foreach($product->attrsGroups() as $key => $value)
                        <a class="product-choice js-product-choice @if($product->id === $key) active @endif " data-product-id="{{$key}}" data-html-container=".js-group-{{$product->product_group_id}}" href="{{ route_alias('product.show', $value["link"]) }}">
                            <span class="checkbox-block"></span>
                            <span class="checkbox-text">{{$value["value"]}}{{$value["suffix"]}}</span>
                        </a>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="item__info-color color-block-wrapper item__info-color-group-{{$product->product_group_id}}" data-group-class="item__info-color-group-{{$product->product_group_id}}"></div>
        <div class="item__info-buttons">
            @if($tining->isNotEmpty())
                <button type="button" data-group-wrapper="js-group-{{$product->product_group_id}}" data-product-group="item__info-color-group-{{$product->product_group_id}}" data-product-id="{{$product->id}}" class="btn-gen btn-tinting js-button-color">{{trans('site.Колеровка')}}</button>
            @endif
                <button type="button" data-html-container=".js-cart-in-header" data-color-id="" data-product-id="{{$product->id}}" class="btn-gen js-add-to-cart">{{ trans('site.В корзину') }}</button>
        </div>
    </div>
</div>