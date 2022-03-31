@extends('layouts.homepage')
@section('content')

    <!-- STAR HEADER SEARCH -->
    <div id="map-container" class="fullwidth-home-map dark-overlay">
        <!-- Video -->
        <div class="video-container">
            <video poster="images/bg/video-poster2.png" loop autoplay muted>
                <source src="video/5.mp4" type="video/mp4">
            </video>
        </div>
        <div id="hero-area" class="main-search-inner search-2 vid">
            <div class="container vid" data-aos="zoom-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hero-inner2">
                            <!-- Welcome Text -->
                            <div class="welcome-text">
                                <h1 class="mb-2"><span>Find Your Dream</span> Home</h1>
                                <p class="mb-0">We Have Over Million Properties For You.</p>
                            </div>
                            <!--/ End Welcome Text -->
                            <div class="col-6" style="margin-left: 300px !important">
                                <div class="banner-search-wrap">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="tabs_1">
                                            <div class="rld-main-search">
                                                <form action="{{ route('search')}}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="rld-single-input">
                                                            <input type="text" placeholder="Enter Keyword..." name="search"
                                                                required>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-2 col-md-4 pl-0">
                                                            <button class="btn btn-yellow" type="submit">Search Now</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER SEARCH -->

    <!-- START SECTION FEATURED PROPERTIES -->
    <section class="featured portfolio bg-white">
        <div class="container">
            <div class="sec-title">
                <h2><span>Recent </span>Properties</h2>
                <p>We provide full service at every step.</p>
            </div>
            <div class="row portfolio-items">
                @foreach ($properties as $key => $property)
                    <div class="item col-lg-4 col-md-4 col-xs-12 landscapes sale">
                        <div class="project-single" data-aos="zoom-in">
                            <div class="project-inner project-head">
                                <div class="homes">
                                    <!-- homes img -->
                                    <a href="{{ route('property.name', $property->id) }}" class="homes-img">
                                        {{-- <div class="homes-tag button alt featured">{{ $property->feature_property ? 'Featured' : '' }}</div> --}}
                                        <div class="homes-tag button alt sale">{{ $property->type->name ?? '' }}</div>
                                        <div class="homes-price">Ksh {{ $property->property_price ?? '' }}/mo</div>
                                        @if ($property->property_main_photo)
                                            <img src="{{ $property->property_main_photo->getUrl() }}" alt="home-1"
                                                class="img-responsive">
                                        @endif

                                    </a>
                                </div>
                                <div class="button-effect">
                                    <a href="{{ route('property.name', $property->id) }}" class="btn"><i
                                            class="fa fa-link"></i></a>
                                    <a href="{{ $property->property_video ?? '' }}"
                                        class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
                                    <a href="{{ route('property.name', $property->id) }}" class="img-poppu btn"><i
                                            class="fa fa-photo"></i></a>
                                </div>
                            </div>
                            <!-- homes content -->
                            <div class="homes-content">
                                <!-- homes address -->
                                <h3><a
                                        href="{{ route('property.name', $property->id) }}">{{ $property->property_title ?? '' }}</a>
                                </h3>
                                <p class="homes-address mb-3">
                                    <a href="{{ route('property.name', $property->id) }}">
                                        <i class="fa fa-map-marker"></i><span>{{ $property->location ?? '' }}</span>
                                    </a>
                                </p>
                                <!-- homes List -->
                                {{-- <ul class="homes-list clearfix">
                                    @foreach ($property->amenities as $key => $item)
                                        <span class="badge badge-success text-white">{{ $item->name }}</span>
                                    @endforeach
                                </ul> --}}
                                <div class="footer">
                                    <a>
                                        <img src="http://itaraheroku.herokuapp.com/static/tenant/ltr/assets/images/faces/male/1.jpg"
                                            alt="" class="mr-2"> {{ $property->created_by->name ?? '' }}
                                    </a>
                                    <span>
                                        <i class="fa fa-calendar"></i> {{ $property->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="bg-all">
                <a href="{{ route('all.properties') }}" class="btn btn-outline-light">View All</a>
            </div>
        </div>
    </section>
    <!-- END SECTION FEATURED PROPERTIES -->

    <!-- START SECTION WHY CHOOSE US -->
    <section class="how-it-works bg-white-2">
        <div class="container">
            <div class="sec-title">
                <h2><span>Why </span>Choose Us</h2>
                <p>We provide full service at every step.</p>
            </div>
            <div class="row service-1">
                <article class="col-lg-4 col-md-6 col-xs-12 serv" data-aos="fade-up">
                    <div class="serv-flex">
                        <div class="art-1 img-13">
                            <img src="images/icons/icon-4.svg" alt="">
                            <h3>Wide Renge Of Properties</h3>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center">lorem ipsum dolor sit amet, consectetur pro adipisici consectetur
                                debits adipisicing lacus consectetur Business Directory.</p>
                        </div>
                    </div>
                </article>
                <article class="col-lg-4 col-md-6 col-xs-12 serv" data-aos="fade-up">
                    <div class="serv-flex">
                        <div class="art-1 img-14">
                            <img src="images/icons/icon-5.svg" alt="">
                            <h3>Trusted by thousands</h3>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center">lorem ipsum dolor sit amet, consectetur pro adipisici consectetur
                                debits adipisicing lacus consectetur Business Directory.</p>
                        </div>
                    </div>
                </article>
                <article class="col-lg-4 col-md-6 col-xs-12 serv mb-0 pt" data-aos="fade-up">
                    <div class="serv-flex arrow">
                        <div class="art-1 img-15">
                            <img src="images/icons/icon-6.svg" alt="">
                            <h3>Financing made easy</h3>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center">lorem ipsum dolor sit amet, consectetur pro adipisici consectetur
                                debits adipisicing lacus consectetur Business Directory.</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <!-- END SECTION WHY CHOOSE US -->


    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="featured portfolio rec-pro disc">
        <div class="container-fluid">
            <div class="sec-title discover">
                <h2><span>Discover </span>Popular Properties</h2>
                <p>We provide full service at every step.</p>
            </div>
            <div class="portfolio col-xl-12">
                <div class="slick-lancers">
                    @foreach ($properties_all as $key => $property)
                        <div class="agents-grid" data-aos="fade-right">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <!-- homes img -->

                                            <a href="{{ route('property.name', $property->id) }}" class="homes-img">
                                                {{-- <div class="homes-tag button alt featured">Featured</div> --}}
                                                <div class="homes-tag button alt sale">{{ $property->type->name ?? '' }}
                                                </div>
                                                <div class="homes-price">Ksh {{ $property->property_price ?? '' }}/mo
                                                </div>
                                                @if ($property->property_main_photo)
                                                    <img src="{{ $property->property_main_photo->getUrl() }}"
                                                        alt="home-1" class="img-responsive">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="button-effect">
                                            <a href="{{ route('property.name', $property->id) }}" class="btn"><i
                                                    class="fa fa-link"></i></a>
                                            <a href="{{ $property->property_video ?? '' }}"
                                                class="btn popup-video popup-youtube"><i class="fas fa-video"></i></a>
                                            <a href="{{ route('property.name', $property->id) }}"
                                                class="img-poppu btn"><i class="fa fa-photo"></i></a>
                                        </div>
                                    </div>
                                    <!-- homes content -->
                                    <div class="homes-content">
                                        <!-- homes address -->
                                        <h3><a
                                                href="{{ route('property.name', $property->id) }}">{{ $property->type->name ?? '' }}</a>
                                        </h3>
                                        <p class="homes-address mb-3">
                                            <a href="{{ route('property.name', $property->id) }}">
                                                <i
                                                    class="fa fa-map-marker"></i><span>{{ $property->location ?? '' }}</span>
                                            </a>
                                        </p>
                                        <!-- homes List -->
                                        {{-- <ul class="homes-list clearfix">
                                            <li>
                                                <span>6 Bedrooms</span>
                                            </li>
                                            <li>
                                                <span>3 Bathrooms</span>
                                            </li>
                                            <li>
                                                <span>720 sq ft</span>
                                            </li>
                                            <li>
                                                <span>2 Garages</span>
                                            </li>
                                        </ul> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION RECENTLY PROPERTIES -->

    <!-- START SECTION BLOG -->
    <section class="blog-section">
        <div class="container">
            <div class="sec-title">
                <h2><span>Articles &amp; </span>Tips</h2>
                <p>Read the latest news from our blog.</p>
            </div>
            <div class="news-wrap">
                <div class="row">
                    @foreach ($blogs as $key => $blog)
                        <div class="col-xl-4 col-md-6 col-xs-12">
                            <div class="news-item" data-aos="fade-up">
                                <a class="news-img-link">
                                    <div class="news-item-img">
                                        @if ($blog->photo)
                                            <img class="img-responsive" src="{{ $blog->photo->getUrl() }}"
                                                alt="blog image">
                                        @endif

                                    </div>
                                </a>
                                <div class="news-item-text">
                                    <a>
                                        <h3>{{ $blog->title ?? '' }}</h3>
                                    </a>
                                    <div class="dates">
                                        <span class="date"> {{ $blog->created_at->diffForHumans() }} &nbsp;/</span>
                                        {{-- <ul class="action-list pl-0">
                                            <li class="action-item pl-2"><i class="fa fa-heart"></i> <span>306</span>
                                            </li>
                                            <li class="action-item"><i class="fa fa-comment"></i> <span>34</span></li>
                                            <li class="action-item"><i class="fa fa-share-alt"></i> <span>122</span>
                                            </li>
                                        </ul> --}}
                                    </div>
                                    <div class="news-item-descr big-news">
                                        {!! Str::limit($blog->description, 120) !!}
                                    </div>
                                    {{-- <div class="news-item-bottom">
                                        <a class="news-link">Read more...</a>
                                        <div class="admin">
                                            <p>By, Karl Smith</p>
                                            <img src="images/testimonials/ts-6.jpg" alt="">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION BLOG -->

    <!-- STAR SECTION PARTNERS -->
    <div class="partners bg-white">
        <div class="container">
            <div class="sec-title">
                <h2><span>Our </span>Partners</h2>
                <p>The Companies That Represent Us.</p>
            </div>
            <div class="owl-carousel style2">
                @foreach ($ourPartners as $key => $ourPartner)
                    <div class="owl-item" data-aos="fade-up">
                        @if ($ourPartner->logo)
                            <img src="{{ $ourPartner->logo->getUrl() }}" alt="">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- END SECTION PARTNERS -->
@endsection
