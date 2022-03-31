@extends('layouts.frontend')

@section('content')

<div class="container mt-md-3 mb-5">
    <div class="row">
        <div class="col-md order-2">
            <div class="row">
                <div class="col-12 text-center mb-3 mt-3">
                    <h2 class="section-title">It’s your <span class="color-red">pinned products</span></h2>
                    <div class="section-title-text">Review what you love. Grab your desires.<br>Share your list with your loved one.</div>
                </div>
            </div>
            <div class="row">
                <?php
                for ($i = 0; $i < 9; $i++) {
                    $prodBlock = '
            <div class="col-6 col-md-4">
                <div class="prod-list-block rounded">
                    <a href="prod-added.php" title="WEDDING SIGN" class="link">
                        <div class="prod-list-img rounded">
                            <img src="assets/img/base_layout/prod-img.jpg" class="w-100">
                        </div>
                        <h3 class="prod-title">WEDDING SIGN</h3>
                    </a>
                    <div class="prod-price-wrapper row gutter-16">
                        <div class="col-lg-6 price">
                            <div class="label">Price</div>
                            <span class="number">$42.00</span>
                        </div>
                        <div class="col-lg-6 qtd">
                            <div class="label">Quantity</div>
                            <div class="prod-list-qtd-input custom-qtd-input">
                                <a href="javascript:;" class="qtd-less" rel="nofollow">-</a>
                                <input type="text" name="qtd" value="1">
                                <a href="javascript:;" class="qtd-more" rel="nofollow">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex prod-list-actions">
                        <a href="#" title="Add to cart" class="btn btn-add-cart"><i class="icon-cart d-md-none"></i><span class="d-none d-md-block">ADD TO CART</span></a>
                        <a href="#" title="Add to wishlist" class="btn btn-add-wishlist active"><i class="icon-wishlist"></i></a>
                    </div>
                </div>
            </div>
            ';
                    echo $prodBlock;
                }
                ?>
            </div>
            <div class="row mb-5">
                <div class="col-12 text-center mb-3 mt-3">
                    <h2 class="section-title text-uppercase">Share</h2>
                    <div class="section-title-text">Insert some sentence right here about something of our product<br>Get ready to see what is trending on Speedy Order</div>
                    <div class="social-media-wrapper">
                        <a href="https://www.facebook.com/speedyorders/" target="_blank" title="Facebook" class="social-media-link"><i class="icon-facebook"></i></a>
                        <a href="https://www.instagram.com/speedyorderusa/" target="_blank" title="Intagram" class="social-media-link"><i class="icon-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/speedyorders" target="_blank" title="Linkedin" class="social-media-link"><i class="icon-linkedin"></i></a>
                        <a href="https://twitter.com/SpeedyOrders" target="_blank" title="twitter" class="social-media-link"><i class="icon-twitter"></i></a>
                        <a href="https://www.youtube.com/channel/UCaU60IjroKy0ka9Y3gmqsBQ" target="_blank" title="youtube" class="social-media-link"><i class="icon-youtube"></i></a>
                        <a href="https://www.pinterest.com/speedyorders/" target="_blank" title="pinterest" class="social-media-link"><i class="icon-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 order-1 account-side-info-wrapper">
            <div class="account-side-title d-md-none">My Account<i class="fa fa-caret-down"></i></div>
            <div class="mt-md-5 account-side-info">
                <img src="assets/img/profile-img.jpg" alt="Name" class="rounded mb-3 account-side-img">
                <p class="text-uppercase"><b>Name</b></p>
                <p class="text-uppercase">Adderess</p>
                <p class="text-uppercase">e-Mail</p>
                <a href="#" title="Edit account info" class="btn-link">Edit account info</a>
                <div class="discounts-wrapper rounded bg-light-gray text-center">
                    Accumulated discounts: <br>
                    <b>us$ 130,98</b>
                </div>
                <hr>
                <h3>Last Purchases:</h3>
                <div class="mb-1">01/02/2021</div>
                <div class="d-flex align-items-center flex-wrap mb-4 last-purchase-img">
                    <a href="#" class="img"><img src="assets/img/base_layout/prod-img.jpg" alt="Name" class="w-100 rounded"></a>
                    <a href="#" class="img"><img src="assets/img/base_layout/prod-img.jpg" alt="Name" class="w-100 rounded"></a>
                    <a href="#" class="img"><img src="assets/img/base_layout/prod-img.jpg" alt="Name" class="w-100 rounded"></a>
                    <a href="#" title="" class="see-more"><i class="far fa-plus-square"></i></a>
                </div>
                <div class="mb-1">01/02/2021</div>
                <div class="d-flex align-items-center flex-wrap mb-4 last-purchase-img">
                    <a href="#" class="img"><img src="assets/img/base_layout/prod-img.jpg" alt="Name" class="w-100 rounded"></a>
                    <a href="#" class="img"><img src="assets/img/base_layout/prod-img.jpg" alt="Name" class="w-100 rounded"></a>
                    <a href="#" class="img"><img src="assets/img/base_layout/prod-img.jpg" alt="Name" class="w-100 rounded"></a>
                    <a href="#" title="" class="see-more"><i class="far fa-plus-square"></i></a>
                </div>
                <a href="#" title="See all" class="btn-link px-4">See all</a>
                <hr>
                <div class="account-notification-wrapper">
                    <h3>Notifications:</h3>
                    <div class="item"><i class="fas fa-exclamation-circle"></i>Your coupon is about to expire</div>
                    <div class="item"><i class="fas fa-exclamation-circle"></i>Your coupon is about to expire</div>
                    <div class="item"><i class="fas fa-exclamation-circle"></i>Your coupon is about to expire</div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection