@extends('layouts.app')

@section('title')
    <title>BabyPassport| {{$city->city}} </title>
@endsection

@section('content')

    <!-- CITY BG IMAGE -->
    <section class=" view bg-city-container px-5"
             style="background-image: url({{asset('storage/cities/'.$city->bg_image)}})">

        <div class="mask rgba-purple-light"></div>
       

        <div class="row justify-content-center justify-content-lg-start">

            <div class="col-12 col-md-8 col-lg-6">
                <h1 class="h1-responsive white-text">
                    Tu bebé en {{$city->city}}
                </h1>
                <p class="lead white-text text-justify my-5">
                    {{$city->copy}}
                </p>
            </div>


        </div>


    </section>



    <!-- CITY HOSPITALS -->
    <section class="hospitals container mt-5">

        <div class="row">
            @foreach($city->hospitals as $hospital)
                <div class="col-12 col-md-6 col-lg-4 mt-5">
                    <!-- Card -->
                    <div class="card shadow-none">

                        <!-- Card image -->
                        <div class="view overlay">
                            <img class="mx-auto rounded" style="max-height: 200px;"
                                 src="{{asset('storage/hospitals/'.$hospital->photo)}}"
                                 alt="Baby Passport {{$hospital->name}}">
                            <a href="#!">
                                <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>

                        <!-- Card content -->
                        <div class="card-body">

                            <!-- Title -->
                            <h4 class="card-title text-dark">{{$hospital->name}}</h4>
                            <p>
                                @for($i=1;$i<=$hospital->rating->star_number;++$i)
                                    <i class="fas fa-star text-spray"></i>
                                @endfor
                            </p>
                            <!-- Text -->
                            <p class="card-text text-justify text-grey-suit">
                                {{substr($hospital->about,0,150)}} ...
                            </p>


                            <!-- Button -->
                            <a href="{{route('web.getHospital',[rawurlencode($hospital->name)])}}"
                               class="btn btn-ce-soir white-text float-right button-border clearfix">
                                Ver más información
                            </a>

                        </div>

                    </div>
                    <!-- Card -->


                </div>
            @endforeach
        </div>

    </section>



    <!-- BLOG POSTS -->
    <section class="container-fluid blogs my-5 ">
        <h3 class="h3-responsive text-center">Más información para ti</h3>
        <div class="section-divider bg-mandys-pink my-3"></div>
        <div class="row justify-content-center justify-content-md-start justify-content-xl-start">
            @foreach ($blogs as $blog)
                @include('_partials/welcome/blog_item')
            @endforeach
        </div>
    </section>
    <!-- END BLOG POSTS -->



@endsection



@section('custom_scripts')
    <script src="{{asset(mix('/js/web/city.js'))}}"></script>
@endsection
