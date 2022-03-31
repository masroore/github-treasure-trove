@extends('front.layouts.base')

@push('css')
@endpush

@section('og')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="RA MRAV - Rezultati pretrage"/>
    <meta property="og:image" content="{{ asset('media/images/logo.png') }}"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta property="og:url" content="{{ \Illuminate\Support\Facades\Request::fullUrl() }}"/>
    <meta property="og:description" content="Djelovanje i aktivnosti Razvojne agencije MRAV d.o.o. usmjerene su na postizanje održivog povećanja životnog standarda i lokalnog razvoja Moslavačke regije i šire."/>
@endsection

@section('content')
    <section id="page-title" class="bgcolor page-title-dark" style="background-image: url({{ asset('media/images/titlebg.jpg') }}); height: 200px;">
        <div class="container clearfix" style="padding-top: 17px;">
            <h1>Pretraga</h1>
            <span>{{ config('app.longname') }}</span>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pretraga</li>
            </ol>
        </div>
    </section>

    <section id="content">
        <div class="content-wrap nobottompadding">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-lg-9">
                        <div class="fancy-title title-double-border">
                            <h3 class="font-weight-light">Pretraga pojma - <strong>"{{ request()->query('q') }}"</strong></h3>
                        </div>

                        <div id="posts" class="small-thumbs">
                            @foreach ($pages as $page)
                                <div class="entry clearfix">
                                    @if (isset($page->image))
                                        <div class="entry-image">
                                            @if (isset($page->subcat->parent))
                                                <a href="{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}"><img class="image_fade img-thumbnail" src="{{ asset($page->image) }}" alt="{{ $page->name }}"></a>
                                            @else
                                                <a href="{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}"><img class="image_fade img-thumbnail" src="{{ asset($page->image) }}" alt="{{ $page->name }}"></a>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="entry-c">
                                        <div class="entry-title">
                                            <h2>
                                                @if (isset($page->subcat->parent))
                                                    <a href="{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}">{{ $page->name }}</a>
                                                @else
                                                    <a href="{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}">{{ $page->name }}</a>
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
