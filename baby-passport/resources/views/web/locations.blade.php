@extends('layouts.app')

@section('title')
    <title>BabyPassport | Ciudades</title>
@endsection

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('content')




    <div class="pt-250 pb-5 mom-search">
        <h1 class="text-ce-soir text-center mb-3">CIUDADES</h1>


        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-12">

                    <p class="text-light p-3 font-weight-bolder bg-ce-soir font-small rounded">
                        ¡ BabyPassport se encarga de gestionar el proceso de citas, ningún doctor te atenderá de
                        manera
                        directa !
                    </p>

                </div>
            </div>


            <div class="row justify-content-start">
                @foreach ($cities as $city)

                    <div class="col-12 col-md-6 col-lg-4 mt-5">
                        <a href="{{route('web.getMomSearchByCity',[rawurlencode($city->city)])}}">
                            <div class="card bg-white doctor-card shadow border-ce-soir">
                                <img src="{{asset('storage/cities/'.$city->image)}}"
                                     class="card-img-top"
                                     alt="Tener a mi bebé en {{$city->city}}">

                                <div class="card-body">
                                    <h2 class="card-title text-ce-soir mb-1">
                                        {{$city->city}}
                                    </h2>
                                    @for($i=1;$i<=$city->rating;++$i)
                                        <i class="fas fa-star text-selective-yellow"></i>

                                    @endfor


                                    <p class="text-grey-suit mb-1 font-small">{{$city->hospitals->count()}}
                                        hospitales</p>
                                </div>
                            </div>
                        </a>
                    </div>

                @endforeach
            </div>


        </div>
    </div>

@endsection

@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"btn-mandys-pink"])
@endsection


@section('custom_scripts')
    <script src="{{asset(mix('/js/web/mom.search.js'))}}"></script>
@endsection
