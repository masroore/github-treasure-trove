@extends('layouts.homepage')
@section('content')

    <!-- START SECTION PROPERTIES LISTING -->
    <section class="properties-list featured portfolio blog bg-white">
        <div class="container">
            <section class="headings-2 pt-0 pb-0">
                <div class="pro-wrapper">
                    <div class="detail-wrapper-body">
                        <div class="listing-title-bar">
                            <div class="text-heading text-left">
                                <p><a href="/">Home </a> &nbsp;/&nbsp; <span>Search results</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row mt-5">
                @if (count($properties) > 0)
                    @foreach ($properties as $property)
                        <div class="item col-lg-4 col-md-6 col-xs-12 landscapes sale">
                            <div class="project-single" data-aos="fade-up">
                                <div class="project-inner project-head">
                                    <div class="homes">
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
                @else
                    <h2 class="text-center text-danger">No Properties Found!!</h2>
                @endif

            </div>
        </div>
    </section>
    <!-- END SECTION PROPERTIES LISTING -->
@endsection
