@extends('layouts.frontend')

@section('content')

<section class="intro-block block-fade-out-bottom block-negative-bottom">
    <div class="intro-block-slider">
        <div class="slider-item">
            <div class="d-flex justify-content-end justify-content-md-center flex-column info">
                <div class="title">Discover our new collection of wedding signs.</div>
                <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
            </div>
            <picture>
                <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-home-intro.jpg">
                <img src="frontend_assets/img/base_layout/home-intro.jpg" alt="Discover our new collection of wedding signs">
            </picture>
        </div>
        <div class="slider-item">
            <div class="d-flex justify-content-end justify-content-md-center flex-column info">
                <div class="title">Discover our new collection 2022!</div>
            </div>
            <picture>
                <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-home-intro-2.jpg">
                <img src="frontend_assets/img/base_layout/home-intro-2.jpg" alt="Discover our new collection of wedding signs">
            </picture>
        </div>
    </div>
</section>

<section class="banner-block mb-4">
    <picture>
        <source media="(max-width: 767px)" srcset="https://via.placeholder.com/768x768">
        <img src="https://via.placeholder.com/2600x675" alt="banner">
    </picture>
</section>

<section class="banner-block promo-banner-block mb-4">
    <div class="d-flex flex-column align-items-center justify-content-center block-fade-out-right info offset-lg-7 col-lg-5 text-center">
        <a href="#" title="Product Name" class="link">
            <div class="promo-tag">Today’s Special</div>
            <div class="promo-discount">50% OFF</div>
            <div class="prod-title">Calendars</div>
            <div class="prod-secondary-title">BIGGEST DISCOUNT</div>
            <div class="prod-price-wrapper"><span class="new">$42.00</span><span class="old">$84.00</span></div>
            <div class="d-none d-lg-block text">Here we will add a description about the product, very clear, very straight forward, answering the normal questions customer have, and being persuasive.</div>
        </a>
        <div class="prod-options-wrapper d-flex flex-wrap">
            <div class="prod-option-block">
                <div class="title">Sizes</div>
                <div class="prod-option-inputs">
                    <input type="radio" id="size_s" value="S" name="prodSize">
                    <label for="size_s">S</label>
                    <input type="radio" id="size_m" value="M" name="prodSize">
                    <label for="size_m">M</label>
                    <input type="radio" id="size_l" value="L" name="prodSize">
                    <label for="size_l">L</label>
                </div>
            </div>
            <div class="prod-option-block">
                <div class="title">personalization</div>
                <div class="prod-option-inputs">
                    <input type="radio" id="personalization_yes" value="Yes Personalization" name="prodPersonalization">
                    <label for="personalization_yes">Yes</label>
                    <input type="radio" id="personalization_no" value="No Personalization" name="prodPersonalization">
                    <label for="personalization_no">No</label>
                </div>
            </div>
        </div>
        <a href="#" title="ADD TO CART" class="btn btn-primary mt-3">ADD TO CART</a>
    </div>
    <picture>
        <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-promo-calendar.jpg">
        <img src="frontend_assets/img/base_layout/promo-calendar.jpg" alt="Discover B2B Store">
    </picture>
</section>

<section class="banner-block promo-banner-block mb-4">
    <div class="d-flex flex-column align-items-center justify-content-center block-fade-out-left info col-lg-5 text-center">
        <a href="#" title="Product Name" class="link">
            <div class="promo-tag">Today’s Special</div>
            <div class="promo-discount">20% OFF</div>
            <div class="prod-title">Calendars</div>
            <div class="prod-secondary-title">BIGGEST DISCOUNT</div>
            <div class="prod-price-wrapper"><span class="new">$42.00</span><span class="old">$84.00</span></div>
            <div class="d-none d-lg-block text">Here we will add a description about the product, very clear, very straight forward, answering the normal questions customer have, and being persuasive.</div>
        </a>
        <div class="prod-options-wrapper d-flex flex-wrap">
            <div class="prod-option-block">
                <div class="title">Sizes</div>
                <div class="prod-option-inputs">
                    <input type="radio" id="size_s" value="S" name="prodSize">
                    <label for="size_s">S</label>
                    <input type="radio" id="size_m" value="M" name="prodSize">
                    <label for="size_m">M</label>
                    <input type="radio" id="size_l" value="L" name="prodSize">
                    <label for="size_l">L</label>
                </div>
            </div>
            <div class="prod-option-block">
                <div class="title">personalization</div>
                <div class="prod-option-inputs">
                    <input type="radio" id="personalization_yes_2" value="Yes Personalization" name="prodPersonalization">
                    <label for="personalization_yes_2">Yes</label>
                    <input type="radio" id="personalization_no_2" value="No Personalization" name="prodPersonalization">
                    <label for="personalization_no_2">No</label>
                </div>
            </div>
        </div>
        <a href="#" title="ADD TO CART" class="btn btn-primary mt-3">ADD TO CART</a>
    </div>
    <picture>
        <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-promo-calendar.jpg">
        <img src="frontend_assets/img/base_layout/promo-calendar.jpg" alt="Discover B2B Store">
    </picture>
</section>

<section class="container mb-5">
    <div class="row">

        <?php
        for ($i = 0; $i < 4; $i++) {
            $couponBlock = '
            <div class="col-6 col-md-3">
                <div class="coupon-list-block rounded">
                    <div class="coupon-list-img rounded">
                        <img src="frontend_assets/img/base_layout/prod-img.jpg" class="w-100">
                    </div>
                    <h3 class="coupon-title">- 10% on All Calerndars</h3>
                    <div class="coupon-price-wrapper row">
                        <div class="col-6 price">
                            <div class="label">Price</div>
                            <span class="number">$42.00</span>
                        </div>
                        <div class="col-6 value">
                            <div class="label">Value</div>
                            <span class="number">$84.00</span>
                        </div>
                    </div>
                    <div class="coupon-countdown-wrapper">
                        <div class="label">EXPIRES IN:</div>
                        <div class="coutndown-element" data-countdown="Dec 25, 2021"></div>
                    </div>
                    <a href="#" title="#" class="btn btn-primary">GRAB YOUR COUPON</a>
                </div>
            </div>
            ';
            echo $couponBlock;
        }
        ?>

        <?php
        for ($i = 0; $i < 4; $i++) {
            $couponBlock = '
            <div class="col-6 col-md-3">
                <div class="coupon-list-block rounded">
                    <div class="coupon-list-img rounded">
                        <img src="frontend_assets/img/base_layout/prod-img.jpg" class="w-100">
                    </div>
                    <h3 class="coupon-title">- 10% on All Calerndars</h3>
                    <div class="coupon-price-wrapper row">
                        <div class="col-6 price">
                            <div class="label">Price</div>
                            <span class="number">$42.00</span>
                        </div>
                        <div class="col-6 value">
                            <div class="label">Value</div>
                            <span class="number">$84.00</span>
                        </div>
                    </div>
                    <div class="coupon-countdown-wrapper">
                        <div class="label">EXPIRES IN:</div>
                        <div class="coutndown-element" data-countdown="Dec 5, 2020"></div>
                    </div>
                    <a href="#" title="#" class="btn btn-primary">GRAB YOUR COUPON</a>
                </div>
            </div>
            ';
            echo $couponBlock;
        }
        ?>

    </div>
</section>

@endsection