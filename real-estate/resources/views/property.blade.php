@extends('layouts.homepage')
@section('content')

    <!-- START SECTION PROPERTIES LISTING -->
    <section class="single-proper blog details">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 blog-pots">
                    <div class="row">
                        <div class="col-md-12">
                            <section class="headings-2 pt-0">
                                <div class="pro-wrapper">
                                    <div class="detail-wrapper-body">
                                        <div class="listing-title-bar">
                                            <h3>{{ $property->property_title }}<span
                                                    class="mrg-l-5 category-tag">{{ $property->location ?? '' }}</span>
                                            </h3>
                                            <div class="mt-0">
                                                <a href="#listing-location" class="listing-address">
                                                    <i
                                                        class="fa fa-map-marker pr-2 ti-location-pin mrg-r-5"></i>{{ $property->type->name ?? '' }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single detail-wrapper mr-2">
                                        <div class="detail-wrapper-body">
                                            <div class="listing-title-bar">
                                                <h4>Ksh {{ $property->property_price }}</h4>
                                                <div class="mt-0">
                                                    <a href="#listing-location" class="listing-address">
                                                        <p>{{ $property->area }} sq ft</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- main slider carousel items -->
                            <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                                <h5 class="mb-4">Gallery</h5>
                                <div class="carousel-inner">
                                    @if ($property->property_main_photo)
                                        <div class="active item carousel-item" data-slide-number="0">
                                            <img src="{{ $property->property_main_photo->getUrl() }}"
                                                class="img-fluid" alt="slider-listing">
                                        </div>
                                    @endif
                                    @foreach ($property->property_photos as $key => $media)
                                        <div class="item carousel-item" data-slide-number="{{ $property->id }}">
                                            <img src="{{ $media->getUrl() }}" class="img-fluid" alt="slider-listing">
                                        </div>
                                    @endforeach

                                    <a class="carousel-control left" href="#listingDetailsSlider" data-slide="prev"><i
                                            class="fa fa-angle-left"></i></a>
                                    <a class="carousel-control right" href="#listingDetailsSlider" data-slide="next"><i
                                            class="fa fa-angle-right"></i></a>

                                </div>
                                <!-- main slider carousel nav controls -->
                                <ul class="carousel-indicators smail-listing list-inline">
                                    @if ($property->property_main_photo)
                                        <li class="list-inline-item active">
                                            <a id="carousel-selector-0" class="selected" data-slide-to="0"
                                                data-target="#listingDetailsSlider">
                                                <img src="{{ $property->property_main_photo->getUrl() }}"
                                                    class="img-fluid" alt="listing-small">
                                            </a>
                                        </li>
                                    @endif
                                    @foreach ($property->property_photos as $key => $media)
                                        <li class="list-inline-item">
                                            <a id="carousel-selector-1" data-slide-to="{{ $property->id }}"
                                                data-target="#listingDetailsSlider">
                                                <img src="{{ $media->getUrl() }}" class="img-fluid"
                                                    alt="listing-small">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <!-- main slider carousel items -->
                            </div>
                            <div class="blog-info details mb-30">
                                <h5 class="mb-4">Description</h5>
                                <p class="mb-3">{!! $property->property_description !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="single homes-content details mb-30">
                        <!-- title -->
                        <h5 class="mb-4">Property Details</h5>
                        <ul class="homes-list clearfix">
                            <li>
                                <span class="font-weight-bold mr-1">Property ID:</span>
                                <span class="det">{{ $property->id }}</span>
                            </li>
                            <li>
                                <span class="font-weight-bold mr-1">Property Type:</span>
                                <span class="det">{{ $property->type->name ?? '' }}</span>
                            </li>
                            <li>
                                <span class="font-weight-bold mr-1">Available status:</span>
                                <span class="det"><input type="checkbox" disabled="disabled"
                                        {{ $property->available ? 'checked' : '' }}></span>
                            </li>
                            <li>
                                <span class="font-weight-bold mr-1">Property Price:</span>
                                <span class="det">Ksh {{ $property->property_price }} /mon</span>
                            </li>
                            <li>
                                <span class="font-weight-bold mr-1">Rooms:</span>
                                <span class="det"> {{ $property->rooms }}</span>
                            </li>
                            <li>
                                <span class="font-weight-bold mr-1">Year Built:</span>
                                <span class="det">{{ $property->year_built }}</span>
                            </li>
                        </ul>
                        <!-- title -->
                        <h5 class="mt-5">Amenities</h5>
                        <!-- cars List -->
                        <ul class="homes-list clearfix">
                            @foreach ($property->amenities as $key => $amenities)
                                <li>
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                    <span>{{ $amenities->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="property wprt-image-video w50 pro mt-5">
                        <h5>Property Video</h5>
                        <img alt="image" src="{{ asset('images/slider/home-slider-4.jpg') }}">
                        <a class="icon-wrap popup-video popup-youtube" href="{{ $property->property_video }}">
                            <i class="fa fa-play"></i>
                        </a>
                        <div class="iq-waves">
                            <div class="waves wave-1"></div>
                            <div class="waves wave-2"></div>
                            <div class="waves wave-3"></div>
                        </div>
                    </div>
                    <div class="floor-plan property wprt-image-video w50 pro">
                        <h5>Floor Plans</h5>
                        @if ($property->floor_plans)
                            <img alt="image" src="{{ $property->floor_plans->getUrl() }}">
                        @endif

                    </div>
                    {{-- <div class="property-location map">
                        <h5>Location</h5>
                        <div class="divider-fade"></div>
                        <div id="map-contact" class="contact-map"></div>
                    </div> --}}
                    <!-- Star Reviews -->
                    <section class="reviews comments">
                        <h3 class="mb-5">Reviews</h3>
                        @foreach ($propertyReviews as $reviews)
                            <div class="row m-4">
                                <ul class="col-12 commented pl-0">
                                    <li class="comm-inf">
                                        {{-- <div class="col-md-2">
                                        <img src="images/testimonials/ts-5.jpg" class="img-fluid" alt="">
                                    </div> --}}
                                        <div class="col-md-10 comments-info">
                                            <div class="conra">
                                                <h5 class="mb-2">{{ $reviews->full_name }}</h5>
                                                <div class="rating-box">
                                                    <div class="detail-list-rating mr-0">
                                                        @if ($reviews->ratings == 1)
                                                            <i class="fa fa-star"></i>
                                                        @elseif ($reviews->rating == 2)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif ($reviews->ratings == 3)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif ($reviews->ratings == 4)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif ($reviews->ratings == 5)
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-4">{{ $reviews->created_at->diffForHumans() }}</p>
                                            <p>{{ $reviews->review }}</p>
                                            {{-- <div class="rest"><img src="images/single-property/s-1.jpg" class="img-fluid"
                                                alt=""></div> --}}
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        @endforeach

                    </section>
                    <!-- End Reviews -->
                    <!-- Star Add Review -->
                    <section class="single reviews leve-comments details">
                        <div id="add-review" class="add-review-box">
                            <!-- Add Review -->
                            <h3 class="listing-desc-headline margin-bottom-20 mb-4">Add Review</h3>
                            @if (Auth::check())
                                <span class="leave-rating-title">Your rating for this property</span>
                                <!-- Rating / Upload Button -->
                                <form action="{{ route('property.review') }}" method="post">
                                    @csrf
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <!-- Leave Rating -->
                                            <div class="clearfix"></div>
                                            <div class="leave-rating margin-bottom-30">
                                                <input type="radio" name="ratings" id="rating-1" value="1" />
                                                <label for="rating-1" class="fa fa-star"></label>
                                                <input type="radio" name="ratings" id="rating-2" value="2" />
                                                <label for="rating-2" class="fa fa-star"></label>
                                                <input type="radio" name="ratings" id="rating-3" value="3" />
                                                <label for="rating-3" class="fa fa-star"></label>
                                                <input type="radio" name="ratings" id="rating-4" value="4" />
                                                <label for="rating-4" class="fa fa-star"></label>
                                                <input type="radio" name="ratings" id="rating-5" value="5" />
                                                <label for="rating-5" class="fa fa-star"></label>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                   <!-- Uplaod Photos -->
                                   <div class="add-review-photos margin-bottom-30">
                                       <div class="photoUpload">
                                           <span><i class="sl sl-icon-arrow-up-circle"></i> Upload Photos</span>
                                           <input type="file" class="upload" />
                                       </div>
                                   </div>
                               </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 data">
                                            {{-- <form action="#"> --}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="full_name" class="form-control"
                                                        placeholder="First Name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Last Name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="Email" required>
                                                </div>
                                            </div>
                                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                                            <div class="col-md-12 form-group">
                                                <textarea class="form-control" name="review" id="exampleTextarea"
                                                    rows="8" placeholder="Review" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-lg mt-2">Submit
                                                Review</button>
                                </form>
                        </div>
                </div>
            @else
                <a href="/login" class="btn btn-lg btn-block mt-3">Sign in to review</a>
                @endif
            </div>
    </section>
    <!-- End Add Review -->
    </div>
    <aside class="col-lg-4 col-md-12 car">
        <div class="single widget">
            <!-- End: Schedule a Tour -->
            <!-- end author-verified-badge -->
            <div class="sidebar">
                <div class="widget-boxed mt-33 mt-5">
                    <div class="widget-boxed-header">
                        <h4>Owner Information</h4>
                    </div>
                    <div class="widget-boxed-body">
                        <div class="sidebar-widget author-widget2">
                            <div class="author-box clearfix text-center">
                                {{-- <img src="http://itaraheroku.herokuapp.com/static/tenant/ltr/assets/images/faces/male/1.jpg" alt="author-image" class="author__img"> --}}
                                <h4 class="author__title">{{ $property->created_by->name ?? '' }}</h4>
                            </div>
                            <ul class="author__contact">
                                <li><span class="la la-map-marker"><i
                                            class="fa fa-map-marker"></i></span>{{ $property->created_by->address ?? '' }}
                                </li>
                                <li><span class="la la-phone"><i class="fa fa-phone"
                                            aria-hidden="true"></i></span><a
                                        href="#">{{ $property->created_by->phone ?? '' }}</a></li>
                                <li><span class="la la-envelope-o"><i class="fa fa-envelope"
                                            aria-hidden="true"></i></span><a
                                        href="#">{{ $property->created_by->email ?? '' }}</a>
                                </li>
                            </ul>
                            <div class="agent-contact-form-sidebar">
                                <h4>Request Inquiry</h4>
                                <form method="post" action="{{ route('property.enquiry') }}">
                                    @csrf
                                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                                    <input type="text" id="fname" name="full_name" placeholder="Full Name" required />
                                    <input type="number" id="pnumber" name="phone_number" placeholder="Phone Number"
                                        required />
                                    <input type="email" id="emailid" name="email_address" placeholder="Email Address"
                                        required />

                                    <textarea placeholder="Message" name="message" required></textarea>
                                    <input type="submit" name="sendmessage" class="multiple-send-message"
                                        value="Submit Request" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-search-field-2">
                    <!-- Start: Specials offer -->
                    <div class="widget-boxed popular mt-5">
                        <div class="widget-boxed-header">
                            <h4>Specials of the day</h4>
                        </div>
                        <div class="widget-boxed-body">
                            <div class="banner"><img src="{{ asset('images/single-property/banner.jpg') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <!-- End: Specials offer -->
                    <div class="widget-boxed popular mt-5">
                        <div class="widget-boxed-header">
                            <h4>Popular Tags</h4>
                        </div>
                        <div class="widget-boxed-body">
                            <div class="recent-post">
                                <div class="tags">
                                    @foreach ($property->tags as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    </div>
    </div>
    </section>
    <!-- END SECTION PROPERTIES LISTING -->
@endsection
