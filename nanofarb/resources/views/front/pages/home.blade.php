@extends('front.layouts.app')

@php
    MetaTag::setEntity($page)->setPath('/')->setDefault(['title' => trans('site.Главная страница') ]);
    $localebound = $page->getLocaleboundStr();
@endphp

@section('content')
    <main>
        <div class="home">
            <div class="circle"></div>
            <div class="home__wrapper">
                <div class="home__name">
                    <span></span>
                    <div class="home__name-group">
                        {!! variable('page_home_titles', '', \UrlAliasLocalization::getCurrentLocale()) !!}
                    </div>
                </div>
                <div class="home__product">
                    <div class="home__product-info">
                        @foreach($categories as $category)
                        <div class="home__product-block">
                            <a href="{{ route_alias('category.show', $category) }}">
                                <img src="{{ $category->getMyFirstMediaUrl('image', 'table', '/its-client/img/home-prod-1.png') }}" alt="{{ $category->name }}">
                                <div class="name">{{ $category->name }}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

{{--                @if(isset($news) && $news->count())--}}
                @if(false)
                <div class="home__feedback">
                    <div class="name-gen">
                        {{ trans('site.Новости') }}
                    </div>
                    <div class="home__feedback-info">
                        <div class="swiper-container swiper-container-feedback">

                            <div class="swiper-wrapper">
                                @foreach($news->chunk(2) as $chunk)
                                    <div class="swiper-slide">
                                        @php
                                            $b = $loop->iteration % 2;
                                        @endphp
                                        @foreach($chunk as $node)
                                            <div class="home__feedback-block @if($b = !$b) gray @endif">
                                                <div class="home__feedback-head">
                                                    {{--<img src="/its-client/img/feedback.png" alt="">--}}
                                                    <a href="{{ route_alias('news.show', $node) }}" class="home__feedback-head-name">{{ $node->name }}
                                                        <div class="home__feedback-date">
                                                            {{ $node->created_at->format('d.m.Y') }}
                                                        </div>
                                                    </a>
                                                    <svg class="icon-svg icon-svg-fullscreen color-red"><use xlink:href="/its-client/img/sprite.svg#fullscreen"></use></svg>
                                                </div>
                                                <div class="home__feedback-content">
                                                    {!! $node->teaser !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="home__feedback-bottom">
                        <a class="feedback-name" href="{{ route_alias('news.index') }}">
                            <svg class="icon-svg icon-svg-remove color-red"><use xlink:href="/its-client/img/sprite.svg#remove"></use></svg>
                            {{ trans('site.Посмотреть все новости') }}
                        </a>
                    </div>
                </div>
                @endif
                <div class="home__contact" id="contacts">
                    <div class="name-gen">
                        {{ trans('site.Контакты') }}
                    </div>
                    <div class="home__contact-wrapper">
                        <div class="home__contact-left">
                            <div class="home__contact-block">
                                <div class="name">
                                    <svg class="icon-svg icon-svg-phone-red color-red"><use xlink:href="/its-client/img/sprite.svg#phone-red"></use></svg>
                                    <span>{{ trans('site.Связаться с нами') }}</span>
                                </div>
                                <p>{!! variable('company_phone', '', \UrlAliasLocalization::getCurrentLocale()) !!}</p>
                                <p><a href="mailto:{!! variable('company_email', '', \UrlAliasLocalization::getCurrentLocale()) !!}">{!! variable('company_email', '', \UrlAliasLocalization::getCurrentLocale()) !!}</a></p>
                            </div>
                            <div class="home__contact-block">
                                <div class="name">
                                    <svg class="icon-svg icon-svg-access-time color-red"><use xlink:href="/its-client/img/sprite.svg#access-time"></use></svg>
                                    <span>{{ trans('site.График работы')}}:</span>
                                </div>
                                {!! variable('company_schedule_map', '
                                    <p> <span>Пн - Пт:</span>10:00 - 19:00</p>
                                    <p> <span>Сб: </span>10:00 - 16:00</p>
                                    <p> <span>Вс:</span>Выходной</p>
                                ', \UrlAliasLocalization::getCurrentLocale()) !!}
                            </div>
                            <div class="home__contact-block">
                                <div class="name">
                                    <svg class="icon-svg icon-svg-place color-red"><use xlink:href="/its-client/img/sprite.svg#place"></use></svg>
                                    <span>{{ trans('site.Наш адрес') }}</span>
                                </div>
                                <p>{!! variable('company_address', 'г.Одесса', \UrlAliasLocalization::getCurrentLocale()) !!}</p>
                            </div>
                        </div>
                        <div class="home__contact-right">
                            <div class="map" id="google-map">
                                <div id="google-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9Qv3PhtLRXw8_cP707YTs8NwHukEnf9k">
    </script>

    <script>
        var latitude = {{ variable('contact_latitude', '59.933349', \UrlAliasLocalization::getCurrentLocale()) }},
            longitude = {{ variable('contact_longitude', '30.336510', \UrlAliasLocalization::getCurrentLocale()) }},
            map_zoom = {{ variable('contact_map_zoom', '9') }};

        var style= [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-100"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 65
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": "50"
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-100"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "30"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "40"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#ffff00"
                    },
                    {
                        "lightness": -25
                    },
                    {
                        "saturation": -97
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels",
                "stylers": [
                    {
                        "lightness": -25
                    },
                    {
                        "saturation": -100
                    }
                ]
            }
        ]


        var map_options = {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: map_zoom,
            panControl: false,
            zoomControl: false,
            mapTypeControl: false,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            styles: style
        }

        var map = new google.maps.Map(document.getElementById('google-container'), map_options);

        var marker = new google.maps.Marker ({
            map: map,
            position: {lat: latitude, lng: longitude},
            // icon: 'img/marker.png'
        })
    </script>
    @endpush
@endsection
