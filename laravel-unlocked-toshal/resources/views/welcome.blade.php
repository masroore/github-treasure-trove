@extends('layouts.app')

@section('content')
<!-- <style>
    body {
        background: aliceblue;
    }

    .gtco-testimonials {
        position: relative;
        margin-top: 30px;

    }

    .gtco-testimonials h2 {
        font-size: 30px;
        text-align: center;
        color: #333333;
        margin-bottom: 50px;
    }

    .gtco-testimonials .owl-stage-outer {
        padding: 30px 0;
    }

    .gtco-testimonials .owl-nav {
        display: none;
    }

    .gtco-testimonials .owl-dots {
        text-align: center;
    }

    .gtco-testimonials .owl-dots span {
        position: relative;
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: block;
        background: #fff;
        border: 2px solid #01b0f8;
        margin: 0 5px;
    }

    .gtco-testimonials .owl-dots .active {
        box-shadow: none;
    }

    .gtco-testimonials .owl-dots .active span {
        background: #01b0f8;
        box-shadow: none;
        height: 12px;
        width: 12px;
        margin-bottom: -1px;
    }

    .gtco-testimonials .card {
        background: #fff;
        box-shadow: 0 8px 30px -7px #c9dff0;
        margin: 0 20px;
        padding: 0 10px;
        border-radius: 20px;
        border: 0;
    }

    .gtco-testimonials .card .card-img-top {
        max-width: 100px;
        border-radius: 50%;
        margin: 15px auto 0;
        box-shadow: 0 8px 20px -4px #95abbb;
        width: 100px;
        height: 100px;
    }

    .gtco-testimonials .card h5 {
        color: #01b0f8;
        font-size: 21px;
        line-height: 1.3;
    }

    .gtco-testimonials .card h5 span {
        font-size: 18px;
        color: #666666;
    }

    .gtco-testimonials .card p {
        font-size: 18px;
        color: #555;
        padding-bottom: 15px;
    }

    .gtco-testimonials .active {
        opacity: 0.5;
        transition: all 0.3s;
    }

    .gtco-testimonials .center {
        opacity: 1;
    }

    .gtco-testimonials .center h5 {
        font-size: 24px;
    }

    .gtco-testimonials .center h5 span {
        font-size: 20px;
    }

    .gtco-testimonials .center .card-img-top {
        max-width: 100%;
        height: 120px;
        width: 120px;
    }

    .owl-carousel .owl-nav button.owl-next,
    .owl-carousel .owl-nav button.owl-prev,
    .owl-carousel button.owl-dot {
        outline: 0;
    }
</style> -->
<script>
    function venue_search() {
        var amenity = jQuery("input[name='amenity[]']:checked")
            .map(function() {
                return $(this).val();
            }).get();
        var rating = jQuery("input[name='rating']:checked").attr("data-value");
        var searchKeyword = jQuery("#searchKeyword").val();
        var daterange = jQuery("#daterange").val();
        var price = jQuery("#price").val();
        var sorting = jQuery("#sorting").val();
        var no_of_people = jQuery("#no_of_people").val();
        jQuery.ajax({
            url: baseurl + "/show_venue/" + searchKeyword,
            data: {
                // category_id: searchKeyword
                daterange: daterange,
                price: price,
                rating: rating,
                amenity: amenity,
                sorting: sorting,
                no_of_people: no_of_people
            },
            success: function(data) {
                jQuery(".displayVenues").html(data);
            },
            error: function(jqXHR, exception) {
                var msg = '';
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                console.info(msg);
            }
        });
    }
</script>
<main class="wrapper">
    <!-- banner-section-start -->
    <section class="home-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-xl-10">
                    <div class="banner-content">
                        <h1 class="title" data-aos="zoom-in">
                            Repurposing London's unique <span class="red-font border-img">cultural</span> spaces
                        </h1>
                    </div>
                    <div class="banner-search-bar">
                        <p class="search-txt" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">Find and
                            contact unique venues in london for your next event</p>
                        <form id="categorySearch" name="category_id" method="POST" action="{{route('show_cat_venue')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="search-block">
                                <div class="row">
                                    <div class="col-md-3 col-4">
                                        <div class="custom-drop cat-drp">
                                            <h3 class="font-eighteen">Category Type</h3>
                                            <select class="form-control" id="searchKeyword" name="category_id" required>
                                                <option value="">Category Type</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-4">
                                        <div class="custom-drop cat-drp">
                                            <h3 class="font-eighteen">Gueste</h3>
                                            <select class="form-control" name="guest">
                                                <option value="1 - 100">1 - 100 Guests</option>
                                                <option value="100 - 200">100 - 200 Guests</option>
                                                <option value="200 - 300">200 - 300 Guests</option>
                                                <option value="300 - 400">300 - 400 Guests</option>
                                                <option value="400 - 500">400 - 500 Guests</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-4">
                                        <div class="custom-drop cat-drp">
                                            <h3 class="font-eighteen">Location</h3>
                                            <select class="form-control">
                                                <option value=5>select locations</option>
                                                <option value="1">Edinburgh</option>
                                                <option value=2>London</option>
                                                <option value=3>Glasgow</option>
                                                <option value=4>Newcastle</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="custom-search">
                                            <button class="search-btn btn red-onover" id="searchCategory" type="submit"><img src="{{asset('assets/image/search-icon.svg')}}" alt="search" class="cstm-search-icon">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="logo-block">
                            <div class="row">
                                <div class=" col-lg-9">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets/image/logo1.png')}}" alt="logo"></a></li>
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets/image/logo2.png')}}" alt="logo"></a></li>
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets/image/logo3.png')}}" alt="logo"></a></li>
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets/image/logo4.png')}}" alt="logo"></a></li>
                                        <li class="list-inline-item"><a href="#"><img src="{{asset('assets/image/logo5.png')}}" alt="logo"></a></li>
                                        <li class="list-inline-item"> </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3">
                                    <div class="enquirebtn-box">
                                        <a href="#" class="btn enquire-btn red-onover">Enquire here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner-section-end -->
    <!-- vanue-section-start -->
    <section class="venue-section pt">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="venue-heading">
                        <h2 class="sub-title">Venues Instead Of Cities</h2>
                    </div>
                    <div class="venues-block">
                        <div class="row">
                            @foreach($categories as $category)
                            <div class="col-md-3 col-6 mb-3" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                <div class="venue-content full-img">
                                    <a href="{{route('showallcatvenue',[$category->id])}}">
                                        <img src="{{asset('assets/category/images/'.$category->image)}}" alt="venue-img">
                                    </a>
                                    <div class="venue-img-txt">
                                        <h5 class="small-title text-center">{{$category->name}}</h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- vanue-section-end -->
    <!-- find-vanue-section-start -->
    <section class="fndvenue-section pt pb">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="fndvenue-title t-center">
                        <h2 class="sub-title">Why use Unlocked to find a venue?</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.
                        </p>
                    </div>
                    <div class="fndvenue-block">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-3" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                <div class="fndvenue-content t-center">
                                    <div class="fndvenue-img">
                                        <img src="{{asset('assets/image/venue-icon1.svg')}}" alt="vanue-icon">
                                    </div>
                                    <div class="fndvenue-txt">
                                        <h5 class="font-eighteen mb-2">Affordable <span>Space</span></h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="550">
                                <div class="fndvenue-content t-center">
                                    <div class="fndvenue-img">
                                        <img src="{{asset('assets/image/venue-icon2.svg')}}" alt="vanue-icon">
                                    </div>
                                    <div class="fndvenue-txt">
                                        <h5 class="font-eighteen mb-2">Forward<span> Looking</span></h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="700">
                                <div class="fndvenue-content t-center">
                                    <div class="fndvenue-img">
                                        <img src="{{asset('assets/image/venue-icon3.svg')}}" alt="vanue-icon">
                                    </div>
                                    <div class="fndvenue-txt">
                                        <h5 class="font-eighteen mb-2">Corporate Urban<span> Responsibility</span></h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="850">
                                <div class="fndvenue-content t-center">
                                    <div class="fndvenue-img">
                                        <img src="{{asset('assets/image/venue-icon4.svg')}}" alt="vanue-icon">
                                    </div>
                                    <div class="fndvenue-txt">
                                        <h5 class="font-eighteen mb-2">Events are <span>experiences</span></h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- find-vanue-section-end -->
    <!---vanue-book-section-start -->
    <div class="venue-book-section pb">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="venue-book">
                        <div class="row algn-center">
                            <div class="col-lg-5 col-12" data-aos="fade-right" data-aos-delay="500">
                                <div class="book-img-block">
                                    <img src="{{asset('assets/image/book.png')}}" alt="book">
                                </div>
                            </div>
                            <div class="col-lg-7 col-12" data-aos="fade-left" data-aos-delay="600">
                                <div class="book-content">
                                    <div class="book-title">
                                        Did you know that more than
                                        <span> 66% of the time </span>major spaces
                                        across the city were left empty,
                                        even before the pandemic?
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---vanue-book-section-end -->
    <!---top-vanue-section-start -->
    <section class="top-venue-section pb">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="top-venue-title fndvenue-title t-center">
                        <h2 class="sub-title">3 Top Venues</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et
                            dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.
                        </p>
                    </div>
                    <div class="top-venue-block">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3" data-aos="fade-up" data-aos-delay="500">
                                <div class="events-block full-img">
                                    <div class="event-nm font-seventeen">
                                        Corporate Event
                                    </div>
                                    <img src="{{asset('assets/image/top-venue1.png')}}" alt="event">
                                    <div class="vanue-addrs">
                                        <div class="addrs-txt">
                                            <h5>Rock and Best Villa</h5>
                                            <a href="#"><img src="{{asset('assets/image/right-arrow.svg')}}" alt="arrow"></a>
                                        </div>
                                        <p>Liverpool, London</p>
                                        <strong class="font-twenty">£ 80.50</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3" data-aos="fade-up" data-aos-delay="650">
                                <div class="events-block full-img">
                                    <div class="event-nm font-seventeen">
                                        Party Venue
                                    </div>
                                    <img src="{{asset('assets/image/top-venue2.png')}}" alt="event">
                                    <div class="vanue-addrs">
                                        <div class="addrs-txt">
                                            <h5> Party Venue</h5>
                                            <a href="#"><img src="{{asset('assets/image/right-arrow.svg')}}" alt="arrow"></a>
                                        </div>
                                        <p>Museums, London</p>
                                        <strong class="font-twenty">£ 80.50</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-3" data-aos="fade-up" data-aos-delay="800">
                                <div class="events-block full-img">
                                    <div class="event-nm font-seventeen">
                                        Banqueting Hall
                                    </div>
                                    <img src="{{asset('assets/image/top-venue3.png')}}" alt="event">
                                    <div class="vanue-addrs">
                                        <div class="addrs-txt">
                                            <h5>Grand Venue</h5>
                                            <a href="#"><img src="{{asset('assets/image/right-arrow.svg')}}" alt="arrow"></a>
                                        </div>
                                        <p>Glasgow, London</p>
                                        <strong class="font-twenty">£ 80.50</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!---top-vanue-section-end -->
    <!-- form-section-start -->
    <section class="unlock-form-section pb pt">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="unlock-form-heading">
                        <h2 class="form-title">Try Unlocked for your company</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et
                            dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.
                        </p>
                    </div>
                    <div class="unlock-form form-style" data-aos="fade-up" data-aos-delay="550">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First Name*">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Last Name*">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Work email*">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Phone number*">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Company Name*">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Job Title">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option>What type of virtual/hybrid events ?</option>
                                            <option>type1</option>
                                            <option>type2</option>
                                            <option>type3</option>
                                            <option>type4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option>What is the attendance you're expecting?*
                                            </option>
                                            <option>Weekly</option>
                                            <option>Monthly</option>
                                            <option>yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option>Do you know your budget yet?*</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option>About your virtual/hybrid event?*</option>
                                            <option>event1</option>
                                            <option>event2</option>
                                            <option>event3</option>
                                            <option>event4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Additional information"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-txt-blk">
                                    <div class="unlockbtn-info">
                                        <p class="m-0">By clicking the button below, you agree to Unlocked
                                            Terms of Service
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-btn-blk">
                                    <div class="unlock-btn">
                                        <a href="#" class="enquiry-btn red-onover btn">Send My Enquiry</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- form-section-end -->
    <!---blog-section-start -->
    <section class="blog-section pb pt">
        <div class="container custom-container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="blog-block">
                        <h2 class="sub-title">From Our Blog</h2>
                        <div class="blog-content-block">
                            <div class="blog-content" data-aos="fade-up" data-aos-delay="500">
                                <div class="row">
                                    <div class="col-md-12 col-lg-4">
                                        <div class="blog-img full-img">
                                            <img src="{{asset('assets/image/blog-img1.png')}}" alt="blog">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-12">
                                        <div class="blog-txt">
                                            <span class="blog-date">July 24, 2020</span>
                                            <h5 class="font-twenty">Meet out to help out Unlocked venues
                                                in London
                                            </h5>
                                            <p>Anderson</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-content" data-aos="fade-up" data-aos-delay="650">
                                <div class="row">
                                    <div class="col-md-12 col-lg-4">
                                        <div class="blog-img full-img">
                                            <img src="{{asset('assets/image/blog-img1.png')}}" alt="blog">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-12">
                                        <div class="blog-txt">
                                            <span class="blog-date">July 24, 2020</span>
                                            <h5 class="font-twenty">Meet out to help out Unlocked venues
                                                in London
                                            </h5>
                                            <p>Anderson</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="blog-slider">
                        @if(count($testimonials) > 0)
                        @foreach($testimonials as $testimonial)
                        <div class="blog-item">
                            <div class="blog-item-content">
                                <h2 class="sub-title">{{$testimonial->name}}</h2>
                                <p>{{$testimonial->message}}
                                </p>
                                <div class="blog-inner">
                                    <div class="blog-inner-img">
                                        @if($testimonial->image !="" && $testimonial->image != null)
                                        <img class="card-img-top" src="{{asset('assets/testimonial/images/'.$testimonial->image)}}" alt="">
                                        @else
                                        <img class="card-img-top" src="{{asset('frontend/images/dummyprofile.jpg')}}" alt="">
                                        @endif
                                    </div>
                                    <div class="blog-inner-txt">
                                        <!-- <h5 class="font-twenty mb-1">Oliver anderson </h5> -->
                                        <p class="m-0">{{$testimonial->user_post}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h5 class="font-twenty mb-1">No testimonial Found </h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!---blog-section-end -->
    <!---unlocked-vanue-section-start -->
    <section class="unlocked-vanue-section pb pt">
        <div class="container custom-container">
            <div class="row algn-center">
                <div class="col-md-6">
                    <div class="unlocked-vanue-block">
                        <h2 class="form-title" data-aos="fade-up" data-aos-delay="500">Become an Unlocked venue</h2>
                        <p data-aos="fade-up" data-aos-delay="650">Consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Quis
                            ipsum suspendisse ultrices gravida isus commodo viverra.
                        </p>
                        <ul class="list-unstyled unlocked-vanue-list">
                            <li data-aos="fade-up" data-aos-delay="800"> <i class="fas fa-wifi"></i> Fast & secure wifi
                            </li>
                            <li data-aos="fade-up" data-aos-delay="950"> <i class="fas fa-tag"></i> Plugs </li>
                            <li data-aos="fade-up" data-aos-delay="1050"> <i class="fas fa-wifi"></i> Member Community </li>
                        </ul>
                        <p class="unlocked-vanue-para m-0"><a href="#">Explore Unlocked <img src="{{asset('assets/image/right-arrow.svg')}}" alt="arrow"></a></p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="650">
                    <div class="unlocked-vanue-img">
                        <img src="{{asset('assets/image/unlocked-vanue-img.png')}}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!---unlocked-vanue-section-end -->
</main>

@section('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    jQuery(document).ready(function() {

        //  jQuery(document).on('click', '#searchVenue', function () {
        //     var datastring = jQuery("#venueSearch").serialize();
        //     jQuery.ajax({
        //             url: baseurl+ "/show_venue/",
        //             data:datastring,
        //             success: function(data) {
        //                 jQuery(".displayVenues").html(data);
        //         },  
        //         error: function (jqXHR, exception) {
        //         var msg = '';
        //             msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //                 console.info(msg);
        //             }
        //         });
        //     });


        // jQuery.ajax({
        //     url: baseurl + "/show_venue",
        //     success: function(data) {
        //         jQuery(".displayVenues").html(data);
        //     },
        //     error: function(jqXHR, exception) {
        //         var msg = '';
        //         msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //         console.info(msg);
        //     }
        // });

        //add checked class on checked rating  && filter venues
        jQuery(document).on('click', 'input[name="rating"]', function() {
            jQuery('input[name="rating"]').not(this).prop('checked', false);
            venue_search()
        });

        jQuery(document).on('click', 'input[name="amenity[]"]', function() {
            venue_search()
        });

        //add checked class to checked amenities
        // jQuery(document).on('click', 'input[name="amenity"]', function() {      
        //     jQuery('input[name="amenity"]').prop('checked', false);      
        // });

        //Ajax request to filter data
        jQuery(document).on('click', '#searchVenue', function() {

            venue_search();
        });


        //Read more functionality
        var page = 1

        jQuery(document).on('click', '#loadmore', function() {
            page = page + 1;
            var searchKeyword = jQuery("#searchKeyword").val();
            jQuery("#loadmore").html('Load More..<i class="fa fa-spinner fa-spin"></i>');
            jQuery.ajax({
                url: baseurl + "/show_venue/" + searchKeyword,
                data: {
                    page: page
                },
                success: function(data) {
                    jQuery("#loadmore").html('Load More..');
                    jQuery(".displayVenues").html(data);
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    console.info(msg);
                }
            });
        });

        //daterange filter
        jQuery("#daterange").daterangepicker({
            format: 'YYYY-MM-DD',
            autoclose: true,
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        jQuery('#daterange').on('apply.daterangepicker', function(ev, picker) {
            jQuery(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
        });
        jQuery('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            jQuery(this).val('');
        });
    });
</script>
<!-- @stop -->
@endsection