@extends('front.layouts.base')

@push('css')
    <style>
        .border-img {
            background:white;
            padding:8px;
            border:1px solid #999999;
        }
    </style>
@endpush

@section('og')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Naslovnica - RA MRAV"/>
    <meta property="og:image" content="{{ isset($sliders[0]) ? asset($sliders[0]->image) : asset('media/images/default_slider.jpg') }}"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:description" content="Djelovanje i aktivnosti Razvojne agencije MRAV d.o.o. usmjerene su na postizanje održivog povećanja životnog standarda i lokalnog razvoja Moslavačke regije i šire."/>
@endsection


@section('content')
    @include('front.layouts.partials.slider')

    <section id="content">
        <div class="content-wrap nobottompadding">
            @include('front.home-text-block')

            {{--@include('front.layouts.partials.promo')--}}

            <div class="section notopborder topmargin-sm bottommargin-sm noborder" style="color: #4e4e4e;">
                <div class="container clearfix">
                    <div class="col_one_third nobottommargin center bounceIn animated" data-animate="bounceIn">
                        <i class="i-plain i-xlarge divcenter nobottommargin icon-banknote" style="color: #d9d9d9;"></i>
                        <div class="counter counter-lined"><span data-from="100" data-to="{{ isset($products_data) ? number_format($products_data['amount'], 0, '', '') : 0 }}" data-refresh-interval="90" data-speed="2500" data-comma="true"></span>+</div>
                        <h5>KUNA ODOBRENO</h5>
                    </div>
                    <div class="col_one_third nobottommargin center bounceIn animated" data-animate="bounceIn" data-delay="200">
                        <i class="i-plain i-xlarge divcenter nobottommargin icon-clipboard2" style="color: #d9d9d9;"></i>
                        <div class="counter counter-lined"><span data-from="0" data-to="{{ isset($products_data) ? $products_data['count'] : 0 }}" data-refresh-interval="3" data-speed="2000"></span>+</div>
                        <h5>Projekata Napisano</h5>
                    </div>
                    <div class="col_one_third col_last nobottommargin center bounceIn animated" data-animate="bounceIn" data-delay="400">
                        <i class="i-plain i-xlarge divcenter nobottommargin icon-users" style="color: #d9d9d9;"></i>
                        <div class="counter counter-lined"><span data-from="100" data-to="{{ isset($products_data) ? ($products_data['count'] * 5) : 0 }}" data-refresh-interval="25" data-speed="3500"></span>+</div>
                        <h5>Klijenata usluženo</h5>
                    </div>

                </div>
            </div>


            <div class="container clearfix">
                <div class="heading-block center topmargin bottommargin-sm">
                    <h2>Novosti i objave</h2>
                </div>
                @if(isset($latest))
                    <div id="oc-posts" class="owl-carousel posts-carousel carousel-widget" data-margin="20" data-nav="false" data-pagi="true" data-items-xs="1" data-items-sm="2" data-items-md="2" data-items-lg="3" data-items-xl="3">
                        @foreach ($latest as $page)
                            <div class="oc-item">
                                <div class="ipost clearfix">
                                    <div class="entry-image">
                                        @if (isset($page->subcat))
                                            <a href="{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}"><img class="image_fade img-thumbnail" src="{{ asset($page->image) }}" alt="{{ $page->name }}"{{-- style="background:white;padding:.27rem;border:1px solid #DDDDDD;"--}}></a>
                                        @else
                                            <a href="{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}"><img class="image_fade img-thumbnail" src="{{ asset($page->image) }}" alt="{{ $page->name }}"></a>
                                        @endif
                                    </div>
                                    <div class="entry-title">
                                        @if (isset($page->subcat))
                                            <h3><a href="{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}">{{ $page->name }}</a></h3>
                                        @else
                                            <h3><a href="{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}">{{ $page->name }}</a></h3>
                                        @endif
                                    </div>
                                    <ul class="entry-meta clearfix">
                                        <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make($page->created_at)->locale('hr')->format('d.m.Y') }}</li>
                                        @if (isset($page->blocks->groupBy('type')['image']))
                                            <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                        @endif
                                        @if (isset($page->blocks->groupBy('type')['pdf']))
                                            <li><a href="#"><i class="icon-download"></i></a></li>
                                        @endif
                                    </ul>
                                    <div class="entry-content">
                                        @if (isset($page->meta_description))
                                            <p>{{ $page->meta_description }}</p>
                                        @else
                                            <p>{!! \Illuminate\Support\Str::substr($page->description, 0, 200) !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="clearfix"></div>
                <div class="heading-block center bottommargin-sm topmargin">
                    <h2>Usluge</h2>
                </div>
                <div class="row bottommargin">
                    <div class="col_one_third">
                        <div class="feature-box fbox-center fbox-plain">
                            <div class="fbox-icon" data-animate="bounceIn">
                                <a href="#"><i class="icon-note"></i></a>
                            </div>
                            <h3>Projekti i dokumentacija</h3>
                            <p>Pomažemo Vam razraditi Vašu projektnu ideju, sastaviti koncept i definirati osnovne korake prema njenom ostvarenju.</p>
                        </div>
                    </div>
                    <div class="col_one_third">
                        <div class="feature-box fbox-center fbox-plain">
                            <div class="fbox-icon" data-animate="bounceIn">
                                <a href="#"><i class="icon-line2-layers"></i></a>
                            </div>
                            <h3>Poduzetničke zone</h3>
                            <p>Pružamo Vam potporu u svakom momentu implementacije na mentorskom principu ili uslugama obrazovanja Vaših djelatnika.</p>
                        </div>
                    </div>
                    <div class="col_one_third col_last">
                        <div class="feature-box fbox-center fbox-plain">
                            <div class="fbox-icon" data-animate="bounceIn">
                                <a href="#"><i class="icon-atom1"></i></a>
                            </div>
                            <h3>Poduzetnički Inkubator Kutina</h3>
                            <p>Kako razviti organizaciju, kako izgraditi vlastite kapacitete i gdje ostvariti za to resurse, pitanja su s kojima se susreću svi.</p>
                        </div>
                    </div>
                    {{--@foreach ($services as $page)
                        <div class="col-lg-4 mb-4">
                            <div class="flip-card text-center top-to-bottom">
                                --}}{{--<div class="flip-card-front dark" style="background-image: url({{ ! empty($page->image) ? Image::cache(function ($image) use ($page) { $image->make(asset($page->image))->greyscale()->gamma(3.2)->brightness(10)->encode('data-url'); }, env('CACHE_LIFETIME')) : Image::cache(function ($image) { $image->make(asset('media/temp/slider/1.jpg'))->greyscale()->encode('data-url'); }, env('CACHE_LIFETIME')) }});">--}}{{--
                                <div class="flip-card-front dark" style="background-image: url({{ ! empty($page->image) ? Image::cache(function ($image) use ($page) { $image->make(asset($page->image))->greyscale()->brightness(45)->contrast(72)->encode('data-url'); }, env('CACHE_LIFETIME')) : Image::cache(function ($image) { $image->make(asset('media/temp/slider/1.jpg'))->greyscale()->encode('data-url'); }, env('CACHE_LIFETIME')) }});">
                                    <div class="flip-card-inner">
                                        <div class="card nobg noborder text-center">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ strtoupper($page->name) }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flip-card-back" style="background-image: url({{ ! empty($page->image) ? asset($page->image) : 'media/temp/slider/1.jpg' }});">
                                    <div class="flip-card-inner">
                                        <p class="card-text text-white t400">{{ $page->meta_description }}</p>
                                        @if (isset($page->subcat))
                                            <a href="{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}" class="btn btn-red mt-2">POGLEDAJTE PONUDU</a>
                                        @else
                                            <a href="{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}" class="btn btn-red mt-2">POGLEDAJTE PONUDU</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach--}}
                </div>
            </div>

            <div class="container clearfix bottommargin-sm">
                <div class="clearfix"></div>
                <div class="heading-block center bottommargin-sm topmargin">
                    <h2>Naši Partneri</h2>
                </div>
                <div id="oc-clients" class="owl-carousel image-carousel carousel-widget" data-margin="60" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false" data-items-xs="2" data-items-sm="3" data-items-md="4" data-items-lg="5" data-items-xl="6">
                    <div class="oc-item"><a href="#"><img src="{{ asset('media/images/partners/amp.png') }}" alt="Clients"></a></div>
                    <div class="oc-item"><a href="https://www.kutina.hr/"><img src="{{ asset('media/images/partners/kt.png') }}" alt="Clients"></a></div>
                    <div class="oc-item"><a href="#"><img src="{{ asset('media/images/partners/erasmus.png') }}" alt="Clients"></a></div>
                    <div class="oc-item"><a href="https://lag-moslavina.hr/"><img src="{{ asset('media/images/partners/lag.png') }}" alt="Clients"></a></div>
                    <div class="oc-item"><a href="https://inkubator-punk.hr/"><img src="{{ asset('media/images/partners/punk.png') }}" alt="Clients"></a></div>
                    <div class="oc-item"><a href="https://rk-smz.hr/"><img src="{{ asset('media/images/partners/simora.png') }}" alt="Clients"></a></div>
                    <div class="oc-item"><a href="#"><img src="{{ asset('media/images/partners/dimitro.png') }}" alt="Clients"></a></div>
                </div>
            </div>

        </div>
    </section>
@endsection


@push('js')
@endpush
