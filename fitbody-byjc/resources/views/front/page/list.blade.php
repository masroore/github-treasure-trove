@extends('front.layouts.base')

@push('css')
@endpush

@section('og')
    @if (isset($page))
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{ $page->name }} - RA MRAV"/>
        <meta property="og:image" content="{{ isset($page->image) && $page->image ? asset($page->image) : asset('media/images/logo-mrav.svg') }}"/>
        <meta property="og:site_name" content="{{ config('app.name') }}"/>
        <meta property="og:url" content="{{ \Illuminate\Support\Facades\Request::fullUrl() }}"/>
        <meta property="og:description" content="{{ $page->meta_description }}"/>
    @else
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="RA MRAV - {{ $cat->name . (isset($subcat->name) ? $subcat->name : '') }}"/>
        <meta property="og:image" content="{{ asset('media/images/logo.png') }}"/>
        <meta property="og:site_name" content="{{ config('app.name') }}"/>
        <meta property="og:url" content="{{ \Illuminate\Support\Facades\Request::fullUrl() }}"/>
        <meta property="og:description" content="Djelovanje i aktivnosti Razvojne agencije MRAV d.o.o. usmjerene su na postizanje održivog povećanja životnog standarda i lokalnog razvoja Moslavačke regije i šire."/>
    @endif
@endsection


@section('content')
    @include('front.page.partials.page-title')

    <section id="content">
        <div class="content-wrap nobottompadding">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-lg-9">
                        @if (Request::is('usluge/projekti'))
                            <div class="promo promo-light bottommargin">
                                <h3>Pogledajte našu listu projekata</h3>
                                <span>Pružamo Vam potporu u svakom momentu implementacije.</span>
                                <a href="{{ route('project.list') }}" class="button button-dark button-xlarge button-rounded">Lista Projekata</a>
                            </div>
                        @endif
                        <div class="fancy-title title-double-border">
                            <h3 class="font-weight-light">Stranica {{ $pages->currentPage() }}</h3>
                        </div>
                        <div id="posts" class="small-thumbs">
                            @foreach ($pages as $page)
                                <div class="entry clearfix">
                                    @if (isset($page->image))
                                        <div class="entry-image">
                                            @if (isset($page->subcat))
                                                <a href="{{ route('page', ['cat' => $cat->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}"><img class="image_fade img-thumbnail" src="{{ asset($page->image) }}" alt="{{ $page->name }}"></a>
                                            @else
                                                <a href="{{ route('page', ['cat' => $cat->slug, 'subcat' => $page->slug]) }}"><img class="image_fade img-thumbnail" src="{{ asset($page->image) }}" alt="{{ $page->name }}"></a>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="entry-c">
                                        <div class="entry-title">
                                            <h2>
                                                @if (isset($page->subcat))
                                                    <a href="{{ route('page', ['cat' => $cat->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}">{{ $page->name }}</a>
                                                @else
                                                    <a href="{{ route('page', ['cat' => $cat->slug, 'subcat' => $page->slug]) }}">{{ $page->name }}</a>
                                                @endif
                                            </h2>
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
                                            {{ $page->meta_description }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div class="clearfix"></div>

                        {{ $pages->links('front.layouts.partials.paginate') }}
                    </div>

                    <div class="col-lg-3">
                        @include('front.page.partials.services')
                        @include('front.page.partials.latest')
                    </div>
                </div>
            </div>

            @include('front.layouts.partials.promo')

        </div>
    </section>
@endsection


@push('js')
@endpush
