<?php
$title = "Added to cart";
require("includes/header.php");
?>

<section class="container mb-3">
    <div class="row">
        <div class="col-12 col-md-8 mx-md-auto text-center mt-3">
            <h1 class="section-title">You successfully added <br class="d-none d-lg-block"><span class="color-red">your personalized product to cart</span></h1>
        </div>
        <div class="w-100"></div>
        <div class="col-md-6 col-lg-3 mb-5 mx-auto">
            <a href="cart.php" title="Go to cart" class="btn btn-success w-100 text-uppercase">Go to cart</a>
        </div>
        <div class="col-12 text-center mb-3">
            <h2 class="section-title">We don’t sell only, <span class="color-red">we really care about you.</span></h2>
            <div class="section-title-text">Want to add more beautiful calendars to your cart?</div>
        </div>
    </div>
    <div class="row">
        <?php
        for ($i = 0; $i < 8; $i++) {
            $prodBlock = '
            <div class="col-6 col-md-3">
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
                        <a href="prod-added.php" title="Add to cart" class="btn btn-add-cart"><i class="icon-cart d-md-none"></i><span class="d-none d-md-block">ADD TO CART</span></a>
                        <a href="wishlist" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a>
                    </div>
                </div>
            </div>
            ';
            echo $prodBlock;
        }
        ?>
    </div>
</section>

<section class="banner-block">
    <div class="d-flex flex-column align-items-start justify-content-center info col-lg-5 offset-lg-1">
        <div class="title"><i>Discover our new collection of wedding signs</i></div>
        <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
    </div>
    <picture>
        <source media="(max-width: 767px)" srcset="assets/img/base_layout/m-home-intro.jpg">
        <img src="assets/img/base_layout/home-intro-alt.jpg" alt="Discover our new collection of wedding signs">
    </picture>
</section>

<?php require("includes/footer.php"); ?>