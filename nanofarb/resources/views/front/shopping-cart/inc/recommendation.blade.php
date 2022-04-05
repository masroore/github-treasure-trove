<div class="g-wrapper-recomendation">
    <h2 class="g-wrapper-recomendation__title"> {{ trans('site.Рекомендуем') }} </h2>
    <div class="swiper-container swiper-container-recomendation ">
        <div class="swiper-wrapper">
            @foreach($recommendation as $product)
            <div class="swiper-slide">
                @include('front.products.inc.single-product')
            </div>
            @endforeach
        </div>
    </div>
    <div class="swiper-button-next"> <img src="/its-client/img/arrow-right.png" alt=""> </div>
    <div class="swiper-button-prev"> <img src="/its-client/img/arrow-left.png" alt=""></div>
</div>
