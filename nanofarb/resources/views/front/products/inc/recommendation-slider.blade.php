<div class="recomendation-slider">
    <h1 class="home-content__head-name name-gen">{{ trans('site.Так же рекомендуем') }}</h1>
    <div class="swiper-container swiper-container-recomend">
        <div class="swiper-wrapper">
            @foreach($recommends as $product)
                <div class="swiper-slide @if($loop->index > 2) swiper-slide-inner @endif">
                    @include('front.products.inc.single-product', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
    <div class="swiper-button-prev swiper-button-prev-recomend">
    </div>
    <div class="swiper-button-next swiper-button-next-recomend">
    </div>
</div>
