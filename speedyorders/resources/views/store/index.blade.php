@extends('layouts.frontend')

@section('content')
<div class="page-prod-list">

    <div class="banner-block block-fade-out-bottom mb-2">
        <div class="d-flex flex-column align-items-center justify-content-center info text-center col-lg-6 offset-lg-3 px-lg-3">
            <h1>Welcome to our store</h1>
            <p>Want to add more beautiful calendars to your cart?</p>
        </div>
        <picture>
            <source media="(max-width: 767px)" srcset="/frontend_assets/img/base_layout/m-account-intro.jpg">
            <img src="/frontend_assets/img/base_layout/account-intro.jpg" alt="">
        </picture>
    </div>

  
    <div class="container">
        
        <div class="row">
            <div class="col-md-3 col-xl-2 filters-wrapper">
                <div class="filter-title d-md-none">Filters <i class="fa fa-caret-down"></i></div>
                <div class="filters-list">
                    <div class="filter-block">
                        <div class="title"><b>Categories</b></div>
                        <div class="custom-scroll">
                            @if(!empty($categories_list))
                                    <ul style="list-style:none;" class="filter-list">
                                    @foreach($categories_list as $category)                                 
                                        <li class="has-sub-category">
                                            
                                                @if(isset($filter_category_id) && $filter_category_id==$category->id)
                                                    <a style="clear:both" href="{{route('store', ['category_slug' => $category->slug])}}" title="{{$category->name}}" class="filter-option-link"><b>{!!(strlen($category->name) > 30) ? substr($category->name,0,30).'...' : $category->name !!}</b></a>
                                                @else
                                                    <a style="clear:both"  href="{{route('store', ['category_slug' => $category->slug])}}" title="{{$category->name}}" class="filter-option-link">{!!(strlen($category->name) > 30) ? substr($category->name,0,30).'...' : $category->name!!}</a>
                                                @endif

                                                <!-- {{route('store', ['category_slug' => $category->slug])}} -->

                                                <ul style="display:none">
                                                    
                                                    @if(!empty($category->categories))
                                                        @foreach($category->categories as $child_category)

                                                            @if(isset($filter_category_id) && $filter_category_id==$child_category->id)
                                                                <li class="filter-option-link" style="list-style:none;">&nbsp;&nbsp;&nbsp;<a href="{{route('store', ['category_slug' => $child_category->slug])}}" title="{{$child_category->name}}" ><b>{!!(strlen($child_category->name) > 30) ? substr($child_category->name,0,30).'...' : $child_category->name!!}</b></a>
                                                                    </li>
                                                                
                                                            @else
                                                                <li class="filter-option-link" style="list-style:none;">&nbsp;&nbsp;&nbsp;<a href="{{route('store', ['category_slug' => $child_category->slug])}}" title="{{$child_category->name}}" >{!!(strlen($child_category->name) > 30) ? substr($child_category->name,0,30).'...' : $child_category->name!!}</a>
                                                                </li>
                                                            @endif    
                                                        @endforeach
                                                    @endif

                                                </ul>

                                            </li>
                                       
                                    @endforeach
                                    </ul>
                            @endif
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="title">Color</div>
                        <div class="custom-scroll">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="colorWhite">
                                <label class="custom-control-label" for="colorWhite">White</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="colorBlue">
                                <label class="custom-control-label" for="colorBlue">Blue</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="colorRed">
                                <label class="custom-control-label" for="colorRed">Red</label>
                            </div>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="title">Price Range</div>
                        <div class="price-slider">
                            <div id="slider-range"></div>
                            <input type="text" id="amount" readonly>
                        </div>
                    </div>
                    <a href="{{route('store')}}" title="" class="btn btn-small btn-outline-secondary w-100 mt-3">Clean Filters</a>
                </div>
            </div>
            <div class="col-md-9 col-xl-10 px-0 d-flex flex-wrap">

                <div class="col-12 mb-2">
                    <div class="dropdown sortby-dropdown float-right position-relative">
                        <button class="btn dropdown-toggle p-0" type="button" id="sortbyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="header-item-text">Sort By</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sortbyDropdown">
                            <a href="#" title="" class="active">Featured</a>
                            <a href="#" title="">Price: Low to High</a>
                            <a href="#" title="">Price: Hight to Low</a>
                            <a href="#" title="">New in!</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="col-12">
                    <div class="prod-list-block highlight-prod-list rounded">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a href="#" title="WEDDING SIGN" class="link">
                                    <div class="prod-list-img rounded">
                                        <img src="/frontend_assets/img/base_layout/prod-img.jpg" class="w-100">
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 pr-md-5">
                                <div class="h1 mt-3 mt-md-0 mb-3 mb-xl-5"><i>Deals of the week</i></div>
                                <h3 class="prod-title">WEDDING SIGN</h3>
                                <p class="d-none d-lg-block prod-info">Text Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, consecteext Lorem ipsum dolor sit amet, consectev</p>
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
                                    <a href="{{route('wishlist')}}" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                for ($i = 0; $i < 4; $i++) {
                    $prodBlock = '
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="prod-list-block rounded">
                            <a href="javascript:void(0)" title="WEDDING SIGN" class="link">
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
                                <a href="javascript:void(0)" title="Add to cart" class="btn btn-add-cart"><i class="icon-cart d-md-none"></i><span class="d-none d-md-block">ADD TO CART</span></a>
                                <a href="javascript:void(0)" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a>
                            </div>
                        </div>
                    </div>
                ';
                    echo $prodBlock;
                }
                ?>

                <div class="col-12 mb-4">
                    <div class="intro-block-slider">
                        <div class="banner-block">
                            <div class="d-flex flex-column align-items-start justify-content-center info col-lg-5 offset-lg-1">
                                <div class="title"><i>Discover our new collection of wedding signs</i></div>
                                <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
                            </div>
                            <picture>
                                <source media="(max-width: 767px)" srcset="/frontend_assets/img/base_layout/m-home-intro.jpg">
                                <img src="/frontend_assets/img/base_layout/home-intro-alt.jpg" alt="Discover our new collection of wedding signs">
                            </picture>
                        </div>
                        <div class="banner-block">
                            <div class="d-flex flex-column align-items-start justify-content-center info col-lg-5 offset-lg-1">
                                <div class="title"><i>Discover our new collection of wedding signs</i></div>
                                <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
                            </div>
                            <picture>
                                <source media="(max-width: 767px)" srcset="/frontend_assets/img/base_layout/m-home-intro.jpg">
                                <img src="/frontend_assets/img/base_layout/home-intro-alt.jpg" alt="Discover our new collection of wedding signs">
                            </picture>
                        </div>
                    </div>
                </div>

                <?php
                for ($i = 0; $i < 8; $i++) {
                    $prodBlock = '
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="prod-list-block rounded">
                            <a href="javascript:void(0)" title="WEDDING SIGN" class="link">
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
                                <a href="javascript:void(0)" title="Add to cart" class="btn btn-add-cart"><i class="icon-cart d-md-none"></i><span class="d-none d-md-block">ADD TO CART</span></a>
                                <a href="javascript:void(0)" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a>
                            </div>
                        </div>
                    </div>
                ';
                    echo $prodBlock;
                }
                ?>

                <div class="col-12 d-flex mt-3 mb-5"><a href="#" title="View more" class="btn btn-small btn-outline-primary m-auto">View More</a></div>

                <?php /*
                <div class="row"> 
                    
                    @if(count($products) > 0)
                        @foreach($products as $product)         
                            <div class="col-6 col-md-4 col-xl-3">
                                <div class="prod-list-block rounded">
                                    <a href="{{url('/product-details/'.$product->slug)}}" title="{{$product->name}}" class="link">
                                        <div class="prod-list-img rounded">
                                            <img src="{{url('images/products/'.$product->image)}}" class="w-100">
                                        </div>
                                        <h3 class="prod-title">{{substr($product->name, 0, 70)}}...</h3>
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
                                    <div class="d-flex prod-list-actions">
                                        <a href="javascript:void(0)" onclick="addToCart('{{$product->id}}')" id="btn_{{$product->id}}" title="Add to cart" class="btn btn-add-cart"><i class="icon-cart d-md-none"></i><span class="d-none d-md-block">ADD TO CART</span></a>
                                        <a href="{{route('wishlist')}}" title="Add to wishlist" class="btn btn-add-wishlist"><i class="icon-wishlist"></i></a>
                                    </div>
                                    <div style="display: none;" class="alert alert-primary" id="alert_{{$product->id}}" role="alert"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="prod-list-block rounded">                               
                                <h3 class="prod-title">Currently no any products available to display.</h3>
                            </div>
                        </div>                     
                    @endif 
                </div>


                */?>
                   
                
            </div>
        </div>
    </div>
</div>


@endsection