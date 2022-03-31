@extends('front.layouts.base')

@push('css')
    <style>
        .entry-content li {
            margin-left: 39px;
        }
        .entry-content p {
            text-align: justify;
        }
        .entry-content h2 {
            color: #333333 !important;
            margin-top: 36px;
        }
        .entry-content h4 {
            color: #333333 !important;
            margin-top: 36px;
            margin-bottom: 15px;
        }
        .entry-content h4 span {
            color: #333333 !important;
        }
    </style>
@endpush

@section('og')
    @if (isset($page))
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{ $page->name }} - RA MRAV"/>
        <meta property="og:image" content="{{ isset($page->image) && $page->image ? asset($page->image) : asset('media/images/logo-mrav.svg') }}"/>
        <meta property="og:site_name" content="{{ config('app.name') }}"/>
        <meta property="og:url" content="{{ \Illuminate\Support\Facades\Request::fullUrl() }}"/>
        <meta property="og:description" content="{{ $page->meta_description }}"/>
    @endif
@endsection

@section('content')
    @include('front.page.partials.page-title')

    <section id="content">
        <div class="content-wrap nobottompadding">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="entry-title">
                            <h2>{{ $page->name }}</h2>
                        </div>

                        @if ( ! $cat->single_page)
                            <ul class="entry-meta clearfix">
                                <li><i class="icon-calendar3"></i> {{ \Carbon\Carbon::make($page->created_at)->locale('hr')->format('d.m.Y') }}</li>
                                <li>
                                    <i class="icon-folder-open"></i>
                                    <a href="{{ route('page', ['cat' => $cat]) }}">{{ $cat->name }}</a>,
                                    <a href="#">...</a>
                                </li>
                            </ul>
                        @endif


                        <div class="entry-image">
                            @if ($page->image)
                                <a href="#"><img src="{{ asset($page->image) }}" alt="{{ $page->name }}" class="img-thumbnail"></a>
                            @endif
                        </div>


                        <div class="entry-content notopmargin bottommargin">
                            {!! $page->description !!}

                            <div class="clear"></div>

                            @if ($page->slug == 'kontakt' || $cat->slug == 'kontakt')
                                @include('front.page.partials.contact-form')

                                <div class="clear"></div>

                                <div class="clearfix topmargin bottommargin-sm">
                                    <div class="heading-block ">
                                        <h2>Lokacija</h2>
                                    </div>
                                    <section id="google-map" class="bottommargin">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.3430291707373!2d16.777203451104054!3d45.48303664010479!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476703bf56463bad%3A0xb6c3c1de7b43cd29!2sUl.%20Hrvatskih%20branitelja%202%2C%2044320%2C%20Kutina!5e0!3m2!1sen!2shr!4v1587460667200!5m2!1sen!2shr"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                        <div class="clear"></div>
                                    </section>
                                    <div class="clear"></div>
                                </div>

                            @endif

                            @include('front.page.partials.tags')

                            @if ($page->blocks)
                                @include('front.page.partials.page-block')
                            @endif


                            @include('front.page.partials.share')

                        </div>
                    </div>
                </div>
            </div>

            @if ($page->slug == 'kontakt')

            @endif

            @include('front.layouts.partials.promo')

        </div>
    </section>
@endsection

@push('js')
@endpush
