@extends('front.layouts.base')

@push('css')
@endpush

@section('og')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="RA MRAV - Lista Projekata"/>
    <meta property="og:image" content="{{ asset('media/images/logo.png') }}"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta property="og:url" content="{{ \Illuminate\Support\Facades\Request::fullUrl() }}"/>
    <meta property="og:description" content="Djelovanje i aktivnosti Razvojne agencije MRAV d.o.o. usmjerene su na postizanje održivog povećanja životnog standarda i lokalnog razvoja Moslavačke regije i šire."/>
@endsection


@section('content')

    <section id="page-title" class="bgcolor page-title-dark" style="background-image: url({{ asset('media/images/titlebg.jpg') }}); height: 200px;">
        <div class="container clearfix" style="padding-top: 17px;">
            <h1>{{ config('app.longname') }}</h1>
            <span>Lista Projekata</span>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovnica</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lista Projekata</li>
            </ol>
        </div>
    </section>

    <section id="content">
        <div class="content-wrap nobottompadding">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-lg-9">
                        <div class="fancy-title title-double-border">
                            <h2 class="font-weight-light">Ukupno provedeno <span>{{ $count }}</span> projekata = <span>{{ $sum }} kn</span></h2>
                        </div>
                        <div id="posts" class="small-thumbs">
                            @foreach ($projects as $key => $projects_per_year)
                                <div class="fancy-title title-double-border">
                                    <h3 class="font-weight-light"><strong><span>{{ $key }}</span></strong></h3>
                                </div>
                                @foreach ($projects_per_year as $project)
                                    <div class="entry clearfix">
                                        <div class="entry-c">
                                            <div class="entry-title">
                                                <h2>{{ $project->name }}</h2>
                                            </div>
                                            <ul class="entry-meta clearfix">
                                                <li><i class="icon-calendar3"></i> {{ $project->year }}</li>
                                                <li><i class="icon-camera-retro"></i> {{ $project->carrier }}</li>
                                            </ul>
                                            <div class="entry-content" style="margin-top: 20px;">
                                                {{ $project->project }}<br><br>
                                                <strong>{{ $project->value }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach

                        </div>

                        <div class="clearfix"></div>
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
