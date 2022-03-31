@extends('layouts.frontend')

@section('content')

@php
$homepage_categories = App\Models\Category::where('show_on_homepage', 1)->get();
$featured_categories = App\Models\Category::with('products')->where('is_featured', 1)->get();
@endphp
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

<section class="container services-highlight-wrapper">
    <div class="row gutter-16">
        <div class="col-6 col-md">
            <div class="rounded bg-white mb-4 p-md-2 py-lg-3 px-lg-4 d-flex align-items-center"><i class="icon-home-qualified"></i>
                <div class="text">Dedicated to quality</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="rounded bg-white mb-4 p-md-2 py-lg-3 px-lg-4 d-flex align-items-center"><i class="icon-home-bestprice"></i>
                <div class="text">Best price quality</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="rounded bg-white mb-4 p-md-2 py-lg-3 px-lg-4 d-flex align-items-center"><i class="icon-home-speed"></i>
                <div class="text">Speed and Flexibility</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="rounded bg-white mb-4 p-md-2 py-lg-3 px-lg-4 d-flex align-items-center"><i class="icon-home-professional"></i>
                <div class="text">Professional Consultancy</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="rounded bg-white mb-4 p-md-2 py-lg-3 px-lg-4 d-flex align-items-center"><i class="icon-home-products"></i>
                <div class="text">3 Thousand Products</div>
            </div>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row">
        <div class="col-lg-1">
            <div class="rounded bg-light-gray vertical-text-wrapper">
                <div class="vertical-text-placer">
                    <h2 class="vertical-text">Most Searched</h2>
                </div>
            </div>
        </div>
            
            @if(count($most_searched_products) > 0)
                <div class="col d-flex flex-wrap gutter-16  grid-img-menu-wrapper" data-gridify="3-columns">
                    @foreach($most_searched_products as $search_product)
                        <div class="item">
                            <a href="{{url('/product-details/'.$search_product->slug)}}" title="{{$search_product->name}}" class="grid-img-menu-item card border-0">
                                <img src="{{(isset($search_product->image) && $search_product->image!='') ? url('images/products/'.$search_product->image) : 'https://via.placeholder.com/545x500'}}" class="w-100 rounded">
                               <div class="info info-floating pt-2 text-center d-flex flex-column align-items-center justify-content-center w-100 rounded">
                                    <h3 class="title">{{$search_product->name}}</h3>
                               </div>
                            </a>
                            
                        </div>
                    @endforeach    
                </div>
            @else
                <div class="col d-flex flex-wrap gutter-16  grid-img-menu-wrapper" style="min-height: 215px;">
                    <div class="col-md-12">
                        <div class="rounded">
                           
                                <h3 class="prod-title">Currently no any products available to display.</h3>
                         
                        </div>
                    </div>                         
                </div>    
            @endif
    </div>
</section>

@if(count($latest_products) > 0)

    <section class="container mb-5">
        <div class="row">
            <div class="col-lg-1">
                <div class="rounded bg-light-gray vertical-text-wrapper">
                    <div class="vertical-text-placer">
                        <h2 class="vertical-text">Our Greatest Launch</h2>
                    </div>
                </div>
            </div>
            <div class="col d-flex flex-wrap gutter-16">
                @foreach($latest_products as $latest_product)
                    <div class="col-6 col-lg-3">
                        <a href="{{url('/product-details/'.$latest_product->slug)}}" title="{{$latest_product->name}}" class="card border-0">
                            <img style="min-height:410px;" src="{{(isset($latest_product->image) && $latest_product->image!='') ? url('images/products/'.$latest_product->image) : 'https://via.placeholder.com/545x500'}}" class="w-100 rounded">
                            <div class="info pt-2 mb-4 mb-lg-0">                                
                                <div class="text-small">{{$latest_product->name}}</div>
                            </div>
                        </a>
                    </div>
                @endforeach               
            </div>
        </div>
        <div class="row justify-content-center mt-3 mt-lg-5">
            <div class="col-auto">
                <a href="{{route('store')}}" title="Go to store" class="btn btn-primary w-xs-100">Go to store</a>
            </div>
        </div>
    </section>
@endif  

<script>
 function showtab(category_id){
     $(".tab-pane").removeClass('show active');
     
     $("#pills-category-"+category_id+"-tab").addClass('show active');
 }
</script>  

<section class="bg-light-gray mb-5 home-more-ideas-wrapper">
    <div class="container text-center">
        <h2 class="section-title">More ideas for you</h2>
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-md-center flex-nowrap" id="tabs" role="tablist">
                    @php
                        $index_cat = 0;
                    @endphp
                    @foreach($featured_categories as $feature_category)
                        <li class="nav-item">
                            <a class="nav-link {{($index_cat==0) ? 'active' : ''}}" onclick="showtab('{{$feature_category->id}}')" data-id="{{$feature_category->id}}" id="pills-category-{{$feature_category->id}}" data-toggle="pill" href="#pills-category-{{$feature_category->id}}" role="tab" aria-controls="pills-category-{{$feature_category->id}}" aria-selected="true">{{$feature_category->name}}</a>
                        </li>   
                         @php
                            $index_cat++;
                        @endphp
                    @endforeach  
                </ul>
            </div>

            <div class="col-12 px-0 tab-content" id="home-more-ideasContent">
                 @php
                    $index_cat = 0;
                @endphp
                @foreach($featured_categories as $feature_category)
                
                    <div class="tab-pane fade {{($index_cat==0) ? 'show active' : ''}}" id="pills-category-{{$feature_category->id}}-tab" role="tabpanel" aria-labelledby="pills-category-{{$feature_category->id}}-tab">
                          <div class="col-12 d-flex flex-wrap gutter-16  grid-img-menu-wrapper">
                                @if(count($feature_category->products) > 0)
                                    @foreach($feature_category->products as $featureproduct)
                                            <div class="col-6 col-lg-3">
                                                <a href="#" title="" class="grid-img-menu-item card border-0"><img src="https://modban.com/images/products/{{$featureproduct->image}}" class="w-100 rounded"></a>
                                            </div>
                                    @endforeach
                                @else
                                    <div class="col d-flex flex-wrap gutter-16  grid-img-menu-wrapper" style="min-height: 215px;">
                                        <div class="col-md-12">
                                            <div class="rounded">                                           
                                                    <h3 class="prod-title">Currently no any products available to display.</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                            </div>
                            
                    </div>
                @php
                    $index_cat++;
                @endphp
                @endforeach    
            </div>
        </div>
    </div>
</section>

<section class="banner-block">
    <div class="d-flex flex-column align-items-start justify-content-center block-fade-out-left info col-lg-5">
        <div class="title">B2B Text Lorem ipsum dolor sit amet, consecte</div>
        <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
        <a href="{{route('b2b_home')}}" title="Find out more" class="btn btn-small btn-primary">Find out more</a>
    </div>
    <picture>
        <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-home-b2b.jpg">
        <img src="/frontend_assets/img/base_layout/home-b2b.jpg" alt="Discover B2B Store">
    </picture>
</section>

@endsection