@extends('layouts.app')
@section('content')

<main class="wrapper">
    <!-- banner-section-start -->
    <div class="vanue-detail-banner">
        <div class="venue-detail-slider venue-sliderbtn">
            @if($venue->venue_images->count() > 0)
            @foreach($venue->venue_images as $key => $images)
            <div class="venue-detail-inner">
                <div class="venue-detail-img">
                    <img src="{{asset('assets/venue/images/'.$images->name)}}" alt="slider-img">
                </div>
            </div>
            @endforeach
            @else
            <div class="venue-detail-inner">
                <div class="venue-detail-img">
                    <img class="d-block w-100" src="{{asset('frontend/images/download.png')}}" alt="No Image">
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- banner-section-end -->
    <!-- details-section-start -->
    <section class="details-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="details-block">
                        <div class="detail-rating-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-head">
                                        <h3 class="detail-ttl m-0">{{$venue->name}}</h3>
                                        <p class="font-thirteen mb-2">{{$venue->location}}</p>
                                        <a href="#" class="wifi-tag">Free Wifi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="details-bar">
                            <ul class="list-inline detail-bar-menu">
                                <li class="list-inline-item active"><a href="#overview">Overview</a></li>
                                <li class="list-inline-item"><a href="#facilities">Facilities</a></li>
                                <li class="list-inline-item"><a href="#policies">Policies</a></li>
                                <li class="list-inline-item"><a href="#reviews">Reviews</a></li>
                                <li class="list-inline-item"><a href="#location">Location</a></li>
                                <li class="list-inline-item"><a href="#manager">Manager</a></li>
                                <li class="list-inline-item"><a href="#availability">Availability</a></li>
                            </ul>
                        </div>
                        <div class="venue-detail-info-blk">
                            <div class="venue-info-blk detl-font" id="overview">
                                <h5 class="font-ninteen">About this venue</h5>
                                <p class="font-fourteen">{{$venue->other_information}}</p>
                            </div>
                            <div class="venue-info-blk detl-font" id="overview">
                                <h5 class="font-ninteen">Amenities Detail</h5>
                                <p class="font-fourteen">{{$venue->amenities_detail}}</p>
                            </div>
                            <div class="capacity-block">
                                <h3 class="detail-title">Capacity</h3>
                                <div class="detail-blk-list">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Hall Capacity: <span>Upto {{$venue->no_of_people}}</span>
                                        </li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Hall Capacity: <span>Upto {{$venue->no_of_people}}</span>
                                        </li>
                                        <li class="list-inline-item"><i class="fas fa-check"></i> PersonHall Area: <span> 7300 sq.ft
                                            </span>
                                        </li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> PersonHall Area: <span>7300
                                                sq.ft</span>
                                        </li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Dinning Area: <span>3400 sq.ft</span>
                                        </li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Dinning Area: <span>3400 sq.ft</span>
                                        </li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Stage Area: <span>140 sq.ft</span></li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Stage Area: <span>140 sq.ft</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="capacity-block feature-venue-blk" id="facilities">
                                <h3 class="detail-title">Features of Venue</h3>
                                <div class="detail-blk-list">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> {{$venue->amenities_detail}}</li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Other</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="capacity-block venue-policy" id="policies">
                                <h3 class="detail-title">Venue Policies</h3>
                                <div class="detail-blk-list">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> This hVenue is serviced under the trade
                                            name of Hall Evergreen as per quality standards of Unlocked
                                        </li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit.
                                        </li>
                                        <li class="list-inline-item"><i class="fas fa-check"></i> Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit.
                                        </li>
                                        <li class="list-inline-item"> <i class="fas fa-check"></i> Phasellus in arcu et lorem dignissim
                                            gravida.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="capacity-block map-blk" id="location">
                                <h3 class="detail-title">The local area</h3>
                                <div class="local-map">
                                    <!-- <img src="{{asset('assets/image/map.png')}}" alt="map" class="img-fluid"> -->
                                    <iframe width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=10.305385,77.923029&hl=es;z=14&amp;output=embed"></iframe>
                                </div>
                            </div>
                            <div class="capacity-block find-spc-blk" id="availability">
                                <h3 class="font-twenty">Can’t find the perfect space?</h3>
                                <div class="row algn-center">
                                    <div class="col-sm-6">
                                        <div class="find-spc-content">
                                            <img src="{{asset('assets/image/detail-user.png')}}" alt="detail-user">
                                            <div class="find-txt">
                                                <h5 class="font-fourteen">JOTEN LARA</h5>
                                                <p class="font-thirteen m-0">Liverpool, London</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="find-btn-blk">
                                            <a href="#" class="find-btn btn"><img src="{{asset('assets/image/help-user.svg')}}" alt="help"> Help me find
                                                space</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="detail-right-blk">
                        <div class="booking-blk">
                            <div class="booking-header">
                                <div class="booking-rate">
                                    <div class="booking-rate-txt">{{$venue->booking_price}} <span class="font-thirteen">{{$venue->booking_price}}</span></div>
                                </div>
                                <div class="booking">
                                    <span class="discount">25% off</span>
                                </div>
                            </div>
                            <div class="bk-time">
                                <p class="font-thirteen m-0">3 day 2 night</p>
                            </div>
                            <div class="booking-calndr">
                                <form id="addBooking" name="booking" method="POST" action="{{route('booking_user')}}" enctype="multipart/form-data">
                                    @csrf
                                    @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                    @endif
                                    <div class="cal-blk">
                                        <input type="text" name="booking_name" id="booking_name" value="{{old('booking_name')}}" class="form-control form-control-user" placeholder="Name" required />
                                        @if ($errors->has('booking_name'))
                                        <span class="alert alert-danger">{{ $errors->first('booking_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="cal-blk">
                                        <input type="email" name="booking_email" id="booking_email" value="{{old('booking_email')}}" class="form-control form-control-user datetimepicker" autocomplete="off" placeholder="email" required />
                                        @if ($errors->has('booking_email'))
                                        <span class="alert alert-danger">{{ $errors->first('booking_email') }}</span>
                                        @endif
                                    </div>
                                    <div class="cal-blk">
                                        <input name="date" id="date" value="{{old('date')}}" class="form-control form-control-user booking_date" placeholder="select date" required>
                                        @if ($errors->has('date'))
                                        <span class="alert alert-danger">{{ $errors->first('date') }}</span>
                                        @endif
                                    </div>
                                    <input type="text" name="venue_id" id="venue_id" value="{{$venue->id}}" class="form-control form-control-user" placeholder="Name" required style="display:none" />
                                    <input type="text" name="user_id" id="user_id" value="2" class="form-control form-control-user" placeholder="Name" required style="display:none" />
                                    <div class="cal-blk cal-savings">
                                        <div class="font-fourteen">
                                            Your Savings
                                        </div>
                                        <div class="font-fourteen">
                                            £62.00
                                        </div>
                                    </div>
                                    <div class="cal-total">
                                        <div class="total">
                                            <h5 class="font-fourteen">Total</h5>
                                            <p class="font-thirteen">(incl. of all taxes)</p>
                                        </div>
                                        <div class="total-price">
                                            £{{$venue->booking_price}}
                                        </div>
                                    </div>
                                    <div class="bk-btn">
                                        <button type="submit" id="edit-genre-btn" class="btn book-btn">Continue to Book</button>
                                        <!-- <a type="submit" class="btn book-btn">Continue to Book</a> -->
                                    </div>
                                </form>
                                <div class="cancel-policy">
                                    <p class="font-thirteen m-0">Cancellation Policy</p>
                                    <p class="font-twelve mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing.</p>
                                </div>
                            </div>
                        </div>
                        <div class="booking-reason-blk">
                            <h5 class="font-twenty">5 Reasons to Book
                            </h5>
                            <div class="resn-content">
                                <img src="{{asset('assets/image/loaction.png')}}" alt="location">
                                <div class="reson-txt">
                                    <h6 class="font-fourteen">Location
                                    </h6>
                                    <p class="font-thirteen m-0">Guests rate the Location {{$venue->average_rating}}
                                    </p>
                                </div>
                            </div>
                            <div class="resn-content">
                                <img src="{{asset('assets/image/sleep.png')}}" alt="location">
                                <div class="reson-txt">
                                    <h6 class="font-fourteen">Sleep Quality
                                    </h6>
                                    <p class="font-thirteen m-0">Guests rate the Sleep Quality {{$venue->average_rating}}
                                    </p>
                                </div>
                            </div>
                            <div class="resn-content">
                                <img src="{{asset('assets/image/room.png')}}" alt="location">
                                <div class="reson-txt">
                                    <h6 class="font-fourteen">Rooms
                                    </h6>
                                    <p class="font-thirteen m-0">Guests rate the Rooms {{$venue->average_rating}}
                                    </p>
                                </div>
                            </div>
                            <div class="resn-content">
                                <img src="{{asset('assets/image/service.png')}}" alt="location">
                                <div class="reson-txt">
                                    <h6 class="font-fourteen">Service
                                    </h6>
                                    <p class="font-thirteen m-0">Guests rate the Service {{$venue->average_rating}}
                                    </p>
                                </div>
                            </div>
                            <div class="resn-content">
                                <img src="{{asset('assets/image/value.png')}}" alt="location">
                                <div class="reson-txt">
                                    <h6 class="font-fourteen">Value
                                    </h6>
                                    <p class="font-thirteen m-0">Guests rate the Value {{$venue->average_rating}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="booking-reason-blk enquiry-block">
                            <h5 class="font-twenty">Quick enquiry
                            </h5>
                            <p>Speak to our events team</p>
                            <form class="enquiry-form" name="contact" method="POST" action="{{route('contact_us')}}" enctype="multipart/form-data">
                                @csrf
                                @if(session()->has('contact_message'))
                                <div class="alert alert-success">
                                    {{ session()->get('contact_message') }}
                                </div>
                                @endif
                                @if(session()->has('contact_message_error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('contact_message_error') }}
                                </div>
                                @endif
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn book-btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- details-section-end -->
    <section class="detail-venue-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="detail-venue-title t-center">
                        <h3 class="sub-title" data-aos="zoom-in" data-aos-easing="ease" data-aos-delay="500">Similar venues available in {{$venue->location}}</h3>
                    </div>
                    <div class="detail-venue-slider venue-sliderbtn">
                        @if(sizeof($categoryVenue) > 0)
                        @foreach($categoryVenue as $catVenue)
                        <div class="detail-venue-inner">
                            <div class="card border-0 town-hall-blk">
                                <div class="town-hall-img">
                                    <img src="{{asset('assets/venue/images/'.$catVenue->venue_image)}}" class="img-fluid" alt="town">
                                </div>
                                <div class="card-body town-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="town-content">
                                                <h5 class="font-seventeen">{{$catVenue->name}}</h5>
                                                <p class="font-thirteen m-0">{{$catVenue->name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="filter-border m-0">
                                <div class="town-body town-body-rate">
                                    <div class="town-rate">{{$catVenue->booking_price}}<span class="font-fourteen">{{$catVenue->booking_price}}</span></div>
                                    <a href="{{route('venuedetail',[$catVenue->id])}}" class="card-link font-twelve">View Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h2>No match found</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
@section('scripts')
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('body').on('focus', ".booking_date", function() {
            jQuery(this).datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0
            });
        });
    });

    jQuery(document).on('focus', 'input', function() {
        $('.alert').remove();
    });
</script>
@stop