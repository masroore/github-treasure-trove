@extends('layouts.frontend')

@section('content')

<section class="intro-block mb-5">
    <div class="intro-block-slider">
        <div class="slider-item">
            <div class="d-flex justify-content-end justify-content-md-center flex-column info">
                <div class="title">Discover our new collection of wedding signs.</div>
                <div class="text">Text Lorem ipsum dolor sit amet, consecte</div>
            </div>
            <picture>
                <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-home-intro.jpg">
                <img src="frontend_assets/img/base_layout/home-intro-alt.jpg" alt="Discover our new collection of wedding signs">
            </picture>
        </div>
        <div class="slider-item">
            <div class="d-flex justify-content-end justify-content-md-center flex-column info">
                <div class="title">Discover our new collection 2022!</div>
            </div>
            <picture>
                <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-home-intro-2.jpg">
                <img src="frontend_assets/img/base_layout/home-intro-alt.jpg" alt="Discover our new collection of wedding signs">
            </picture>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="mb-3">Speedy Orders for business</h1>
            <div class="section-title-text">Let’s help you run your business</div>
            <p class="mt-5">Are you starting your dream business or want to take your current business to the next level? Speedy Orders for Business can help. You’ll find all the furniture, decoration and accessories you need, as well as lots of inspiration and practical suggestions. Talk about your ideas with our experts, consult our online planning tools and discover our services, which can help make your dream business come true.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 banner-block mb-4">
            <picture>
                <source media="(max-width: 767px)" srcset="https://via.placeholder.com/768x768">
                <img src="https://via.placeholder.com/1212x710" alt="banner">
            </picture>
        </div>
        <div class="col-md-6 banner-block mb-4">
            <picture>
                <source media="(max-width: 767px)" srcset="https://via.placeholder.com/768x768">
                <img src="https://via.placeholder.com/1212x710" alt="banner">
            </picture>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row">
        <h2 class="col-lg-8 mb-5 h2-light-italic h2-light-italic-bigger">With SpeedyOrders for Business you can save time and money</h2>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="#" title="" class="card border-0">
                <img src="https://via.placeholder.com/788x970" class="w-100 rounded">
                <div class="info info-floating p-0 text-center d-flex align-items-end justify-content-center w-100">
                    <h3 class="title title-dark-bg"><b>Information & contact for SO Business</b></h3>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="#" title="" class="card border-0">
                <img src="https://via.placeholder.com/788x970" class="w-100 rounded">
                <div class="info info-floating p-0 text-center d-flex align-items-end justify-content-center w-100">
                    <h3 class="title title-dark-bg"><b>Easy to Pay</b></h3>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="#" title="" class="card border-0">
                <img src="https://via.placeholder.com/788x970" class="w-100 rounded">
                <div class="info info-floating p-0 text-center d-flex align-items-end justify-content-center w-100">
                    <h3 class="title title-dark-bg"><b>SO plannification for business</b></h3>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="container">
    <div class="row">
        <div class="col-lg-8 mb-3">
            <h2 class="h2-light-italic h2-light-italic-bigger">Your business, your workplace, your way</h2>
            <p>Whether you're in the hospitality industry or want to decorate a workspace, you can find everything you need at Speedy Orders for Business, from durable furniture to practical storage solutions. Let yourself be inspired by the different decorating ideas for your company here.</p>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col d-flex flex-wrap gutter-16 grid-img-menu-wrapper">
            <div class="col-md-6">
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x756" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column">
                        <h3 class="title">Calendars for business</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x600" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column">
                        <h3 class="title">Calendars for business</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x600" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column">
                        <h3 class="title">Calendars for business</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
                <div class="grid-img-menu-item card border-0">
                    <img src="https://via.placeholder.com/1212x756" class="w-100 rounded">
                    <div class="grid-img-menu-info info-floating d-flex justify-content-end align-items-start flex-column">
                        <h3 class="title">Calendars for business</h3>
                        <a href="#" title="" class="btn btn-small btn-outline-primary px-5">Shop Now</a>
                    </div>
                </div>
            </div>
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

@endsection