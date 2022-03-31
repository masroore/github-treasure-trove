@extends('layouts.frontend')

@section('content')


<section class="container mb-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">The {{date('Y')}} collection</h2>
        </div>

           @foreach($products as $product) 
                <div class="col-6 col-md-3">
                    <div class="prod-list-block rounded">

                        <form style="z-index: 1000 !important;" name="product_{{$product->id}}" id="product_{{$product->id}}" action="#">
                            
                            @csrf

                            <a href="{{url('/product-details/'.$product->slug)}}" title="{{$product->name}}" class="link">
                                <div class="prod-list-img rounded">
                                    <img src="{{url('images/products/'.$product->image)}}" class="w-100">
                                </div>
                                <h3 class="prod-title">{{substr($product->name, 0, 80)}}...</h3>
                            </a>
                            <div class="prod-price-wrapper row gutter-16">
                                <div class="col-lg-6 price">
                                    <div class="label">Price</div>
                                    <span class="number">${{$product->sale_price}}</span>
                                </div>
                                <div class="col-lg-6 qtd">
                                    <div class="label">Quantity</div>
                                    <div class="prod-list-qtd-input custom-qtd-input">
                                        <a href="javascript:;" class="qtd-less" rel="nofollow">-</a>
                                        <input type="text" id="quantity_{{$product->id}}" name="quantity_{{$product->id}}" value="1">
                                        <a href="javascript:;" class="qtd-more" rel="nofollow">+</a>
                                    </div>
                                </div>
                            </div>

                            <div id="cart_btn_{{$product->id}}" class="d-flex prod-list-actions">
                                <a href="javascript:void(0)" onclick="addToCart('{{$product->id}}')" id="btn_{{$product->id}}" title="Add to cart" class="btn btn-add-cart"><i class="icon-cart d-md-none"></i><span class="d-none d-md-block">ADD TO CART</span></a>
                                <!-- <a href="wishlist.php" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a> -->
                            </div>
                            <div style="display: none;" class="alert alert-primary" id="alert_{{$product->id}}" role="alert"></div>
                        </form>    

                    </div>
                </div>
          @endforeach

    </div>
</section>

<section class="container mb-5">
    <div class="card border-0 row flex-row">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/1212x756" class="w-100 rounded">
        </div>
        <div class="col-md-6 col-lg-5 info d-flex flex-column justify-content-center text-left">
            <h3 class="h2-light-italic title mb-2">Free shipping over order $120</h3>
            <p class="text">Text Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, consectev</p>
        </div>
    </div>
    <div class="card border-0 row flex-row">
        <div class="col-md-6 col-lg-5 offset-lg-1 info d-flex flex-column justify-content-center text-right">
            <h3 class="h2-light-italic title mb-2">Free shipping over order $120</h3>
            <p class="text">Text Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, consectev</p>
        </div>
        <div class="col-md-6">
            <img src="https://via.placeholder.com/1212x756" class="w-100 rounded">
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row">
        <h2 class="col-lg-6 h2-light-italic my-5">Focus on sitting well and renovating your workplace</h2>
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
                    <h3 class="title">How to structure the renovation of an office space</h3>
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

@endsection