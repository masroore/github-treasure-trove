@extends('front.layouts.base')

@push('css')
@endpush

@section('content')
    @include('front.page.partials.page-title')

    <section id="content">
        <div class="content-wrap nobottompadding">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-lg-9">
                        @if(session('success'))
                            <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div>
                        @endif

                            {{--<div class="row ">
                                <div class="col-xs-12 col-md-6 type-html cm_column">
                                    <div class="cm_item_wrapper">
                                        <div class="cm_item vertical-top text-center">
                                            <div class="promo-style-4" >
                                                          <span class="icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                                    </span>
                                                <h3><b>MOJ KORISNIČKI RAČUN</b></h3>
                                                <p>Uredite vaše korisničke podatke</p>
                                                <a href="{{ route('moj.edit') }}" class="btn btn-neutral" >Uredi</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 type-html cm_column">
                                    <div class="cm_item_wrapper">
                                        <div class="cm_item vertical-top text-center">
                                            <div class="promo-style-4" >
                                                    <span class="icon"><i class="fa fa-commenting" aria-hidden="true"></i>
                                                    </span>
                                                <h3><b>MOJE PORUKE</b></h3>
                                                <p>Pogledajte vae poruke</p>
                                                <a href="{{ route('moj.poruke') }}" class="btn btn-neutral">više</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}

                            <a class="button button-large button-rounded" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ODJAVA
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                    </div>

                    <div class="col-lg-3">
                        {{--@include('front.page.partials.services')--}}
                        @include('front.page.partials.latest')
                    </div>

                    {{--<div class="col-md-12 text-right">
                        <a class="btn btn-neutral" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="si si-logout mr-5"></i> ODJAVA
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>--}}

                </div>
            </div>

            @include('front.layouts.partials.promo')

        </div>
    </section>
@endsection


@push('js')
@endpush
