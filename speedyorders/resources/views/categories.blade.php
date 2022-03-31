@extends('layouts.frontend')

@section('content')

<section class="container mb-5">
    <div class="row">
        <div class="col d-flex flex-wrap gutter-16 grid-img-menu-wrapper">
            <div class="col-lg-6">
                <a href="#" title="" class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x600" class="w-100 rounded">
                    <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                        <h3 class="title">Home</h3>
                        <p class="mb-0">The Best For Your Home</p>
                    </div>
                </a>
                <div class="gutter-16 row">
                    <div class="col-6">
                        <a href="#" title="" class="grid-img-menu-item card border-0">
                            <img src="https://via.placeholder.com/576x615" class="w-100 rounded">
                            <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                                <h3 class="title">Safety</h3>
                                <p class="mb-0">Place copy here</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" title="" class="grid-img-menu-item card border-0">
                            <img src="https://via.placeholder.com/576x615" class="w-100 rounded">
                            <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                                <h3 class="title">Family</h3>
                                <p class="mb-0">Place copy here</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <a href="#" title="" class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/576x660" class="w-100 rounded">
                    <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                        <h3 class="title">Party</h3>
                        <p class="mb-0">Place copy here</p>
                    </div>
                </a>
                <a href="#" title="" class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/576x540" class="w-100 rounded">
                    <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                        <h3 class="title">Wedding</h3>
                        <p class="mb-0">Place copy here</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="#" title="" class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/576x540" class="w-100 rounded">
                    <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                        <h3 class="title">Business</h3>
                        <p class="mb-0">Place copy here</p>
                    </div>
                </a>
                <a href="#" title="" class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/576x660" class="w-100 rounded">
                    <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                        <h3 class="title">Others</h3>
                        <p class="mb-0">Place copy here</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
</section>

<!-- <section class="container mb-5">
  
        <div data-gridify="3-columns">
            
            @foreach($homepage_categories as $category)
                <div class="item">
                    <a href="{{route('product-listings', ['category_slug' => $category->slug])}}" title="" class="grid-img-menu-item card border-0">
                        <img src="{{(isset($category->image) && $category->image!='') ? url('images/categories/'.$category->image) : 'https://via.placeholder.com/545x500'}}" class="w-100 rounded">
                        <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                            <h3 class="title">{{$category->name}}</h3>
                        </div>
                    </a>
                    
                </div>
            @endforeach    

        </div>

   
</section> -->

<section class="container">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Discover what's <span class="color-red">new in summer</span></h2>
            <div class="section-title-text">Renovate your home with our new range of products. <br>Enjoy the elegance of the minimalist decor and the traditional style of this season.</div>
        </div>

        <?php
        for ($i = 0; $i < 4; $i++) {
            $prodBlock = '
            <div class="col-6 col-md-3">
                <div class="prod-list-block rounded">
                    <a href="product-detail.php" title="WEDDING SIGN" class="link">
                        <div class="prod-list-img rounded">
                            <img src="frontend_assets/img/base_layout/prod-img.jpg" class="w-100">
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
                        <a href="wishlist.php" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a>
                    </div>
                </div>
            </div>
            ';
            echo $prodBlock;
        }
        ?>

    </div>
</section>

<!-- <section class="container">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Discover what's <span class="color-red">new in summer</span></h2>
            <div class="section-title-text">Renovate your home with our new range of products. <br>Enjoy the elegance of the minimalist decor and the traditional style of this season.</div>
        </div>

      
            <div class="col-6 col-md-3">
                <div class="prod-list-block rounded">
                    <a href="product-detail.php" title="WEDDING SIGN" class="link">
                        <div class="prod-list-img rounded">
                            <img src="/frontend_assets/img/base_layout/prod-img.jpg" class="w-100">
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
                        <a href="{{route('cart')}}" title="Add to cart" class="btn btn-add-cart"><i class="icon-cart d-md-none"></i><span class="d-none d-md-block">ADD TO CART</span></a>
                        <a href="wishlist.php" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a>
                    </div>
                </div>
            </div>
          
    </div>
</section> -->

<section class="container mb-5">
    <div class="row">
        <div class="col d-flex flex-wrap gutter-16 grid-img-menu-wrapper">
            <div class="col-md-6">
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x756" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column rounded">
                        <h3 class="title">New Calendars Collection for home</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x600" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column rounded">
                        <h3 class="title">New Calendars Collection for home</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x600" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column rounded">
                        <h3 class="title">New Calendars Collection for home</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x756" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column rounded">
                        <h3 class="title">New Calendars Collection for home</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="bg-light-gray mb-5">
    <div class="container">
        <div class="row">
            <h2 class="col h2-light-italic my-5">Focus on feeling well and <br><span class="color-red">renovating your workplace</span></h2>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <a href="#" title="" class="card border-0">
                    <img src="https://via.placeholder.com/788x600" class="w-100 rounded">
                    <div class="info pt-2">
                        <h3 class="title">How to Create an Ergonomic Workplace</h3>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="#" title="" class="card border-0">
                    <img src="https://via.placeholder.com/788x600" class="w-100 rounded">
                    <div class="info pt-2">
                        <h3 class="title">How to structure the renovation of an office space.</h3>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="#" title="" class="card border-0">
                    <img src="https://via.placeholder.com/788x600" class="w-100 rounded">
                    <div class="info pt-2">
                        <h3 class="title">How to renovate an office space</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="banner-block">
    <div class="d-flex flex-column align-items-start justify-content-center info col-lg-5 offset-lg-1">
        <div class="title"><i>Discover our new collection of wedding signs</i></div>
        <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
    </div>
    <picture>
        <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-home-intro.jpg">
        <img src="frontend_assets/img/base_layout/home-intro-alt.jpg" alt="Discover our new collection of wedding signs">
    </picture>
</section>
@endsection
