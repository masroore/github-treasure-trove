<div class="item">
    <div class="item__wrapper js-group-{{$product->product_group_id}}">
        @include('front.products.inc.product-item', ['product' => $product])
    </div>
</div>

{{--
<a href="#" class="home-content__head-like js-action-click
       @if(\Favorite::is($product->id)) active @else favorite-action @endif"
   data-url="{{ route('product-favorite.toggle', $product) }}"
   data-html-container="#product-favorite"
></a>
{{ Currency::format($product->price, $product->currency) }}

<button class="btn-gen js-action-click buy-action"
        data-url="{{ route('shopping-cart.add', $product) }}"
        data-html-container="#product-cart"
>Купить</button>
--}}

