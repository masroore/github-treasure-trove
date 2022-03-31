<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}" charset="utf-8">
    <title>{{ config('app.name', 'Speedy Orders') }}</title>
    <link rel="icon" type="image/png" href="{{url('frontend_assets/img/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{url('frontend_assets/img/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="icon" type="image/x-icon" href="{{url('frontend_assets/img/favicon.ico') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css?ver-5445546446">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style.css?ver-64665') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_icons.css?ver-656646565') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_header.css?ver-3434434') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_footer.css?ver-656766776') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_blocks_layout.css?ver-322434') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_template_pages.css?ver-4565676776') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_product.css?ver-6767767676') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_cart_checkout.css?ver-324356677') }}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend_assets/css/style_account.css?ver-8787') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style type="text/css">
        a.filter-option-link {
            color: #000;
        }
        .filters-list {
            padding-bottom: 10px;
        }
        .inner_ul{
            padding: 0px 0 0 5px;
        }
        image.w-100 {
            width: 100%!important;
            height: 300px !important;
        }
        div#suggesstion-box{
            padding: 0px !important;
        }
        .cat-products{
            margin: 5px 5px 5px 12px
        }
        ul.myMenu {
            padding-left: 2px !important;
        }
        /*.form-control{padding: 0px 5px 0px;}*/


        .buttons-copy, .buttons-csv, .buttons-excel, .buttons-pdf, .buttons-print, .buttons-collection{display: none;} 

        .my-account-cards-intro::after {
    content: "";
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    height: 100%;
    background: linear-gradient(0deg, #fff, rgba(255, 255, 255, 0));
}

  /*  @media (min-width: 768px)
    .new {
        margin-top: -1.5rem!important;
    }
*/
    </style>
</head>

<body>

    @php
        $php_session_id = session()->getId();
        $cart_counts = App\Models\TempCart::where('php_session_id', $php_session_id)->count();

        $homepage_categories = App\Models\Category::where('show_on_homepage', 1)->get();
        $featured_categories = App\Models\Category::with('products')->where('is_featured', 1)->get();

   @endphp

    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto col-md-4 col-lg-3 mr-auto d-flex align-items-center">
                    <a href="javascript:;" class="header-item header-item-menu d-lg-none" rel="nofollow" data-open=".main-menu-wrapper">
                        <span class="icon-menu-bar"></span>
                        <span class="icon-menu-bar"></span>
                        <span class="icon-menu-bar"></span>
                    </a>
                    <a href="{{url('/')}}" title="Homepage" class="d-lg-block mx-lg-auto ml-xl-0"><img srcset="{{url('frontend_assets/img/logo@2x.png 2x') }}" src="{{url('images/'.Option::get('site_logo'))}}" width="245" class="header-logo" alt="Speedy Orders"></a>
                </div>
                <div class="col-auto order-md-3 d-lg-none">
                    <a href="{{route('wishlist')}}" title="Orders" class="header-item header-item-wishlist"><i class="icon-wishlist"></i>
                        <div class="qtd">10</div>
                    </a>
                    <a href="{{route('cart')}}" title="Cart" class="header-item header-item-cart"><i class="icon-cart"></i>
                        <div class="qtd cart_items_count_header">{{($cart_counts > 0) ? $cart_counts : ''}}</div>
                    </a>
                </div>
                <div class="col-12 col-md header-search-wrapper">
                    <form class="d-flex header-search-form">
                        <div class="dropdown search-filter-dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="searchFilterBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                All
                            </button>
                            <div class="dropdown-menu custom-scroll" aria-labelledby="searchFilterBtn">
                                <a href="#" title="filter">All</a>
                                @foreach($homepage_categories as $category)
                                    <a onclick="selectCategory('{{$category->id}}')" href="#" data-id="{{$category->id}}" title="filter">{{$category->name}}</a>
                                @endforeach
                            </div>
                           <input type="hidden" name="top_filter_category" id="top_filter_category">
                           <input type="hidden" id="p_id">
                           <input type="hidden" id="p_slug">
                        </div>
                        <div class="col px-0 form-floating">
                            <input type="text" class="form-control" value="" id="search-box" placeholder="Search Products">
                            <label for="searchInput">Search products </label>
                            
                        </div>
                        
                        <button type="button" onclick="showProductDetails()" class="btn header-search-btn"><i class="icon-search"></i></button>
                    </form>
                    
                    <div id="suggesstion-box"></div>
                </div>
                <div class="d-none d-lg-flex align-items-center justify-content-end col-lg-3">
                    <div class="dropdown currency-dropdown">
                        <button class="btn dropdown-toggle" type="button" id="currencyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="header-item-text">USD</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="currencyDropdown">
                            <a href="#" title="currency" class="active">USD</a>
                            <a href="#" title="currency">Euro</a>
                            <a href="#" title="currency">GBP</a>
                        </div>
                    </div>
                    <a href="{{route('register')}}" title="Register" class="header-item header-item-register"><i class="fa fa-id-badge"></i><span class="header-item-text">Register</span></a>
                    <a href="{{route('login')}}" title="Login" class="header-item header-item-login"><i class="fa fa-user"></i><span class="header-item-text">Login</span></a>
                </div>
            </div>
        </div>
        <div class="header-bottom-bar">
            <div class="container d-lg-flex align-items-center">
                <div class="header-mobile-login d-lg-none">
                    <a href="{{route('register')}}" title="Register">Register</a>
                    <a href="{{route('login')}}" title="Login">Login</a>
                </div>
                <ul class="d-lg-flex flex-lg-wrap align-items-lg-center justify-content-xl-center px-0 col-lg offset-xl-2 main-menu-wrapper">
                    <li><a href="{{route('store')}}" title="Store" class="<?= ($activePage == 'store') ? 'active' : ''; ?>">Store</a></li>
                    <li><a href="{{route('promotions')}}" title="Promotions" class="<?= ($activePage == 'promotions') ? 'active' : ''; ?>">Promotions</a></li>
                    <li><a href="{{route('trendings')}}" title="Trending" class="<?= ($activePage == 'trendings') ? 'active' : ''; ?>">Trending</a></li>
                    <li><a href="{{route('categories')}}" title="Categories" class="<?= ($activePage == 'categories') ? 'active' : ''; ?>">Categories</a></li>
                    <li><a href="{{route('b2b_home')}}" title="Business" class="<?= ($activePage == 'b2b_home') ? 'active' : ''; ?>">Business</a></li>
                    <li><a href="{{route('support')}}" title="Support" class="<?= ($activePage == 'support') ? 'active' : ''; ?>">Support</a></li>
                </ul>
                <div class="header-mobile-location-currency px-0 col-lg-auto">
                    <div class="dropdown">
                        <button class="dropdown-toggle d-flex align-items-end float-lg-right" type="button" id="headerAddress" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-map-pointer"></i>
                            <div>
                                <div class="btn-text">Deliver to</div>
                                <div class="address-value text-truncate">Elk Grove 60007 Elk Grove 60007</div>
                            </div>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="headerAddress">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="mobileAddress" placeholder="Address ZIP">
                                <label for="mobileAddress">Address ZIP </label>
                            </div>
                            <a href="#" title="Save" class="btn btn-small btn-outline-primary mt-2">Save</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="dropdown currency-dropdown d-lg-none">
                        <button class="btn dropdown-toggle" type="button" id="currencyDropdownMobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="header-item-text">USD</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="currencyDropdownMobile">
                            <a href="#" title="currency" class="active">USD</a>
                            <a href="#" title="currency">Euro</a>
                            <a href="#" title="currency">GBP</a>
                        </div>
                    </div>
                </div>
                <a href="{{route('wishlist')}}" title="Orders" class="header-item header-item-wishlist d-none d-lg-flex"><i class="icon-wishlist"></i>
                    <div class="qtd">10</div>
                </a>
                <a href="{{route('cart')}}" title="Cart" class="header-item header-item-cart d-none d-lg-flex"><i class="icon-cart"></i>
                    <div class="qtd cart_items_count_header">{{($cart_counts > 0) ? $cart_counts : ''}}</div>
                </a>
                <!-- logout link only when user is logged in -->
                <a href="#" title="Logout" class="header-mobile-logout d-lg-none">Logout</a>
            </div>
        </div>
    </header>

    <main role="main">

        @php 
            $url = Request::is('pages/*');

        @endphp

        @if($activePage && $activePage!='store' && $activePage!='login' && $activePage!='register' && $activePage!='support' && $activePage!='Pin List'&& $activePage!='Cart' && $activePage!='Delivery' && $activePage!='home' && $activePage!='promotions' && $activePage!='b2b_home')
            @if(!$url)
                <section class="intro-block block-fade-out-bottom block-negative-bottom">
                    <div class="intro-block-slider">
                        <div class="slider-item">
                            <div class="d-flex justify-content-end justify-content-md-center flex-column info">
                                <div class="title">Discover our new collection of wedding signs.</div>
                                <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
                            </div>
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{url('frontend_assets/img/base_layout/m-home-intro.jpg') }}">
                                <img src="{{url('frontend_assets/img/base_layout/home-intro-alt.jpg') }}" alt="Discover our new collection of wedding signs">
                            </picture>
                        </div>
                        <div class="slider-item">
                            <div class="d-flex justify-content-end justify-content-md-center flex-column info">
                                <div class="title">Discover our new collection 2022!</div>
                            </div>
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{url('frontend_assets/img/base_layout/m-home-intro-2.jpg') }}">
                                <img src="{{url('frontend_assets/img/base_layout/home-intro-alt.jpg') }}" alt="Discover our new collection of wedding signs">
                            </picture>
                        </div>
                    </div>
                </section>
            @endif    
        @endif

        @yield('content')
    </main>

<div class="mt-auto"></div>

<a href="{{route('support')}}" title="Support" class="btn-footer-chat"><i class="icon-chat mr-2"></i>Support</a>

<div class="bg-red support-cta-wrapper">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="text">Can’t find what you need?</div>
            <!-- support opens chat -->
            <a href="{{route('support')}}" title="click for support" class="btn btn-outline-light btn-small"><b>Click Here For Support</b></a>
        </div>
    </div>
</div>
<footer class="bg-dark-gray main-footer">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 col-lg-2 footer-menu-block">
                <div class="footer-menu-title">About SO</div>
                <ul class="footer-menu">
                    <li><a href="{{url('/pages/about-so')}}" title="About SO">About SO</a></li>
                    <li><a href="{{url('/pages/careers')}}" title="Careers">Careers</a></li>
                    <li><a href="{{url('/pages/blog')}}" title="Blog">Blog</a></li>
                    <li><a href="{{url('/pages/news')}}" title="News">News</a></li>
                    <li><a href="{{url('/pages/our-service-promise')}}" title="Our Service Promise">Our Service Promise</a></li>
                    <li><a href="{{url('/pages/investor-centers')}}" title="Investor Centre">Investor Centre</a></li>
                    <li><a href="{{url('/pages/delivery-gurantees')}}" title="Delivery Guarantees">Delivery Guarantees</a></li>
                    <li><a href="{{url('/pages/acreylic-cleaning')}}" title="Acrylic Cleaning">Acrylic Cleaning</a></li>
                </ul>
                <img srcset="frontend_assets/img/logo-white-small@2x.png 2x" src="{{url('frontend_assets/img/logo-white-small.png') }}" width="56" class="footer-logo d-none d-lg-block" alt="Speedy Orders">
            </div>
            <div class="col-6 col-md-3 col-lg-2 footer-menu-block">
                <div class="footer-menu-title">Customer Service</div>
                <ul class="footer-menu">
                    <span>1 (773) 236-2966</span>
                    <span>2425 <br> Devon Ave Elk Grove <br> Village IL 60007</span>
                    <li><a href="{{url('/pages/contact-us')}}" title="Contact Us">Contact Us</a></li>
                    <li><a href="{{url('/pages/return-policy')}}" title="Returns Policy">Returns Policy</a></li>
                    <li><a href="{{route('site_map')}}" title="Site Map">Site Map</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 col-lg-2 footer-menu-block">
                <div class="footer-menu-title">Legal</div>
                <ul class="footer-menu">
                    <li><a href="{{url('/pages/terms-and-conditions')}}" title="Terms & Conditions">Terms & Conditions</a></li>
                    <li><a href="{{url('/pages/cookies-policy')}}" title="SO’s Cookies Policy">SO’s Cookies Policy</a></li>
                    <li><a href="{{url('/pages/privacy-policy')}}" title="Privacy Policy">Privacy Policy</a></li>
                    <li><a href="{{route('faq')}}" title="FAQ">FAQ</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 col-lg-2 footer-menu-block">
                <div class="footer-menu-title">My Account</div>
                <ul class="footer-menu">
                    <li><a href="#" title="My Account">My Account</a></li>
                    <li><a href="#" title="Order History">Order History</a></li>
                    <li><a href="{{route('cart')}}" title="Cart">Cart</a></li>
                    <li><a href="#" title="Register">Register</a></li>
                    <li><a href="{{route('wishlist')}}" title="Wishlist">Wishlist</a></li>
                    <li><a href="#" title="Downloads">Downloads</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2 footer-menu-block">
                <div class="footer-menu-title">About the Store</div>
                <div class="footer-menu">
                    <span>Speedy Orders has never been stronger as a company that started as a printing project for Friends and Family.</span>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 footer-menu-block order-lg-7 offset-lg-6">
                <div class="footer-menu-title">Find us</div>
                <ul class="footer-menu">
                    <li><a href="{{url('/pages/contact-us')}}" title="Contact Us">Contact Us</a></li>
                    <li><a href="#" title="Amazon">Amazon</a></li>
                    <li><a href="#" title="ETSY">ETSY</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2 footer-menu-block order-lg-8">
                <div class="footer-menu">
                    <div><span class="footer-cross">X</span><span>4N240 Cavalry DR Ste.B <br> Bloomingdale, IL 60108</span></div>
                    <div><span class="footer-cross">X</span><span>(773) 236-2966</span></div>
                </div>
            </div>
            <div class="col-lg-2 d-flex flex-wrap justify-content-md-end align-items-start align-content-start">
                <img srcset="{{url('frontend_assets/img/logo-white-small@2x.png 2x') }}" src="{{url('frontend_assets/img/logo-white-small.png') }}" width="56" class="footer-logo d-lg-none mr-auto" alt="Speedy Orders">
                <div class="col-8 col-md-12 px-0 text-right social-media-wrapper">
                    <a href="https://www.facebook.com/speedyorders/" target="_blank" title="Facebook" class="social-media-link"><i class="icon-facebook"></i></a>
                    <a href="https://www.instagram.com/speedyorderusa/" target="_blank" title="Intagram" class="social-media-link"><i class="icon-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/speedyorders" target="_blank" title="Linkedin" class="social-media-link"><i class="icon-linkedin"></i></a>
                    <a href="https://twitter.com/SpeedyOrders" target="_blank" title="twitter" class="social-media-link"><i class="icon-twitter"></i></a>
                    <a href="https://www.youtube.com/channel/UCaU60IjroKy0ka9Y3gmqsBQ" target="_blank" title="youtube" class="social-media-link"><i class="icon-youtube"></i></a>
                    <a href="https://www.pinterest.com/speedyorders/" target="_blank" title="pinterest" class="social-media-link"><i class="icon-pinterest"></i></a>
                </div>
            </div>
        </div>
        <div class="row align-items-lg-center footer-bottom-bar">
            <div class="col-md-6 col-lg-5 mb-4 d-md-flex flex-wrap align-items-center payment-methods-block order-lg-2"><div class="mb-2 mb-md-0 mr-md-2">Payment Methods:</div><i class="fab fa-cc-visa ml-md-2"></i><i class="fab fa-cc-mastercard ml-2"></i><i class="fab fa-cc-paypal ml-2"></i><i class="fab fa-cc-amex ml-2"></i><i class="fab fa-cc-discover ml-2"></i></div>
            <div class="col-md-6 mb-4 col-lg-1 text-md-right order-lg-3">Version: 1.21.0</div>
            <div class="col-md-6 mb-3">Copyright © 2021. SpeedyOrders ®, All Rights Reserved</div>
        </div>
    </div>
</footer>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{url('frontend_assets/js/geral.js?ver-545454545') }}" type='text/javascript'></script>
<script src="{{url('frontend_assets/js/gridify.min.js') }}" type='text/javascript'></script>
<script src="{{url('frontend_assets/js/store.js') }}" type='text/javascript'></script>
<script>
    $(document).ready(function(){
    	$("#search-box").keyup(function(){

            return false;
    		$.ajax({
        		type: "POST",
        		url: "{{route('search_products')}}",
        		data:'keyword='+$(this).val()+'&top_filter_category='+$("#top_filter_category").val()+"&_token="+$('meta[name="_token"]').attr('content'),
        		beforeSend: function(){
        			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
        		},
        		success: function(data){
        			$("#suggesstion-box").show();
        			$("#suggesstion-box").html(data);
        			$("#search-box").css("background","#FFF");
        		}
    		});



                                
    	});

        window.onload = function() {
            gridify.init();
        };

    });

    $(".change_qty").click(function(){
            var productId = $(this).attr("id");
            

            setTimeout(function(){
                var product_qty = $("#qty_p_current_"+productId).val();
                var product_unit_price = parseFloat($("#price_product_"+productId).text()).toFixed(2);
                var total_p_price = parseFloat(product_unit_price * parseInt(product_qty)).toFixed(2); 
                var product_unit_price = $("#total_"+productId).text(total_p_price);

                var p_total_single = 0;
                var grand_total_price = 0;
                $(".product-subtotal").each(function(){
                    p_total_single = $(this).text();
                    grand_total_price = parseFloat(grand_total_price) + parseFloat(p_total_single);
                });

                $("#grand_total_price").text(parseFloat(grand_total_price).toFixed(2));

                // Update quantity in DB
                var url = '/updateProductQty';
                $.ajax({
                    url: url,
                    type: 'post',
                    data: 'product_id=' + productId +"&product_qty="+product_qty+"&_token="+$('meta[name="_token"]').attr('content'),
                    dataType: 'JSON',
                    success: function(data) {
                        
                    }
                });

            }, 100);
    });
    
    function selectProduct(p_id, slug) {

        var p_name = $("#product_name_"+p_id).text();        
        var p_slug = $("#p_slug"+p_id).attr('data-product-slug');

        $("#search-box").val(p_name);
        $("#suggesstion-box").hide();

        $("#p_id").val(p_id);
        $("#p_slug").val(p_slug);

    }

    function selectCategory(val) {
        $("#top_filter_category").val(val);
        $("#search-box").val('');
        $("#suggesstion-box").hide();
    }

    function showProductDetails(){
        var productId = $("#p_id").val();
        if(productId && productId!=''){
            var productSlug = $("#p_slug_"+productId).attr('data-product-slug');


            var url = '/updateToSearch';

            $.ajax({
                url: url,
                type: 'post',
                data: 'product_id=' + productId+"&_token="+$('meta[name="_token"]').attr('content'),
                dataType: 'JSON'
            });

            window.location.href = "{{url('/product-details/')}}/"+productSlug;
        } else {
            window.location.href = "{{route('store')}}";
        }

    }

    function addToCart(productId){
        $("#cart_btn_"+productId).attr('disabled', true); 
        var url = '/addtocart';
        var formdata = $("#product_"+productId).serialize();
        var quantity_p = $('#quantity_'+productId).val();
      
        $.ajax({
            url: url,
            type: 'post',
            data: formdata + '&product_id=' + productId+"&quantity_"+productId+"="+quantity_p+"&_token="+$('meta[name="_token"]').attr('content'),
            dataType: 'JSON',
            success: function(data) {
                $(".cart_items_count_header").html(data.cart_items_count);

               $("#cart_btn_"+productId).attr('disabled', false); 
               $("#alert_"+productId).html("Success! Product added in the cart successfully!").show(); 

               setTimeout(function(){
                    $("#alert_"+productId).hide('slow');
               },2000);
            }
        });
    }

    function removeFromCart(productId){

        if(!confirm('Are you sure you want to remove selected item from cart?')){
            return false;
        }
    
        var url = '/removefromcart';

        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": $('meta[name="_token"]').attr('content'),
                "product_id": productId
            },
            dataType: 'JSON',
            success: function(data) {
               $("#tr_"+productId).remove();

               $(".cart_items_count_header").html(data.cart_items_count);

               setTimeout(function(){
                    var grand_total_price = 0;
                   $(".product-subtotal").each(function(){
                        p_total_single = $(this).text();
                        grand_total_price = parseFloat(grand_total_price) + parseFloat(p_total_single);
                    });

                    $("#grand_total_price").text(parseFloat(grand_total_price).toFixed(2));

                    if(grand_total_price == parseFloat('0.00').toFixed(2)){
                        console.log("Global"+grand_total_price);
                        $("#cart_items_list_tr").html('<tr><th colspan="8">No Item in the cart</th></tr>');
                    }

               },200);
               
            }
        });
      }

    function deliveryTimePrice(productId, deliveryTimeId){
        var url = '/deliverytimeprice';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": $('meta[name="_token"]').attr('content'),
                "product_id": productId,
                "delivery_time_id": deliveryTimeId
            },
            dataType: 'JSON',
            success: function(data) {
                 var span_data = data ;
                 $("#deliveryprice_"+productId).text(span_data);


                 var product_price = $("#price_product_"+productId).text();
                 var product_qty = $("#qty_product_"+productId).text();

                 var total_p = parseFloat(product_price) * parseInt(product_qty);

                 $("#shipping_price_"+productId).text(data.toFixed(2));

                 var total_price = parseFloat(total_p) + parseFloat(data);
                 $("#total_"+productId).text(total_price.toFixed(2));


                  var sum = 0;
                  $('.product-subtotal').each(function(){

                      sum += parseFloat($(this).text());
                  });

                  $("#grand_total").text(" $" + sum.toFixed(2));
            }
        });
    }

    function myFunction() {
      var input, filter, ul, li, a, i;
      input = document.getElementById("mySearch");
      filter = input.value.toUpperCase();
      ul = document.getElementById("myMenu");
      li = ul.getElementsByTagName("li");
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    }
</script>

</body>

</html>