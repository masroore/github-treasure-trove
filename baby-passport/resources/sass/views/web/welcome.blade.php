@extends('layouts.app')


@section('content')


 <!-- SLIDER CONTAINER-->
    <section class="main-carousel owl-carousel owl-theme">

        <!-- SLIDER 1 -->
        <div class="row pt-5 pt-lg-0">
            <div class="col-12 pt-4 pt-lg-0">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe  src="https://player.vimeo.com/video/389576211?autoplay=1&loop=1&muted=1&autopause=0" frameborder="0" class="embed-responsive-item"
                            height="200" allow="autoplay"></iframe>
                            
                </div>
            </div>
        </div>
        <!-- END SLIDER 1 -->
        
        
        <!-- SLIDER 2 -->
        <div class="row mt-5 mt-lg-0 mx-0 align-items-center view slider bg2 margin-slider">
   
            <!-- SLIDER 2 COPY -->
            <div class="col-12 col-lg-6 white-text text-shadow">
                <h2 class="h2-responsive">Te asesoramos para que puedas</h2>
            <h1 class="h2-responsive"> dar a luz en Estados Unidos de forma segura.</h1>
            
            </div>
            
            </div>
      <!-- END SLIDER 2 -->
            
        
        
        <!-- SLIDER 3 -->
        <div class="row mt-5 mt-lg-0 mx-0 align-items-center view slider bg3 margin-slider">
   
        <!-- SLIDER 3 COPY -->
        <div class="col-12 col-lg-6 white-text text-shadow">
        <h1 class="h2-responsive">Tu parto en las manos de los mejores médicos de Estados Unidos.</h1>
        
        </div>
        
        </div>
        <!-- END SLIDER 3 -->
        
        
        </section>
        
   <!-- END SLIDER CONTAINER -->


    <!-- MORE INFORMATION -->
    <section class="cities container-fluid pt-4 pt-lg-5">

        <h2 class="h2-responsive text-ce-soir text-center mb-1">MÁS INFORMACIÓN PARA TI</h2>
        <div class="section-divider bg-mandys-pink mt-3"></div>

        <div class="row pt-lg-5">
            <div class="col-12 pt-4 pt-lg-0 px-0">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe  src="https://player.vimeo.com/video/396560752" frameborder="0" class="embed-responsive-item"
                            height="200" allow="autoplay"></iframe>
                            
                </div>
            </div>
        </div>

    </section>
    <!-- MORE INFORMATION -->


    <!-- CITIES -->
    <section class="cities container-fluid pt-4 pt-lg-5">

        <h2 class="h2-responsive text-ce-soir text-center mt-3">CIUDADES PARA DAR A LUZ EN ESTADOS UNIDOS</h2>
        <div class="text-grey-suit text-center lead">Descubre los destinos que tenemos para ti.</div>
        <div class="section-divider bg-mandys-pink mt-3"></div>


        <div class="row my-0 my-lg-3 justify-content-center justify-content-md-start justify-content-xl-start mr-2">
            @foreach($cities as $city)
           
         
                @include('_partials/welcome/city_item',['city'=>$city])
               
            @endforeach
        </div>


    </section>
    <!-- END CITIES -->

    <h2 class="h2-responsive text-spray text-center pt-4">NUESTROS PACIENTES</h2>
    <div  class="text-grey-suit text-center lead">Testimoniales</div >

    <div class="section-divider bg-mandys-pink my-3"></div>

    <!-- VIDEOS SLIDER -->

    <section class="video-carousel owl-carousel owl-theme">

        <div class="container-fluid px-3 px-lg-0">

            <div class="row">
                <div class="col-12">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="https://player.vimeo.com/video/389585417?loop=1" frameborder="0"
                                class="embed-responsive-item"
                                height="200"></iframe>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mx-3 mt-3">

                <div class="col-12 col-lg-md-6 col-lg-9">

                    <div class="streak text-center">
                        <div class="flex-center">
                            <ul class="mb-0 list-unstyled">
                                <li>

                                    <p class="lead font-weight-bolder text-grey-suit">
                                        <i class="fas fa-quote-left text-mandys-pink mr-3" aria-hidden="true"></i>
                                        La verdad es que el servicio cumplio todas mis expectativas, el personal me explico muy bien, realmente saben lo que estan haciendo. Estoy muy contenta con el proceso.
                                        <i class="fas fa-quote-right text-mandys-pink ml-3" aria-hidden="true"></i>
                                    </p>

                                </li>
                                <li class="mb-0">
                                    <h3 class="h3-responsive text-center font-italic mb-0 text-ce-soir">Ana Karen</h3>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

     
        </div>
        <div class="container-fluid px-3 px-lg-0">

        <div class="row">
            <div class="col-12">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="https://player.vimeo.com/video/389587358?loop=1" frameborder="0" class="embed-responsive-item"
                            height="200"></iframe>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">

            <div class="col-10 col-lg-md-6 col-lg-9">

                <div class="streak text-center">
                    <div class="flex-center">
                        <ul class="mb-0 list-unstyled">
                            <li>

                                <p class="lead font-weight-bolder text-grey-suit">
                                    <i class="fas fa-quote-left text-mandys-pink mr-3" aria-hidden="true"></i>
                                    Estamos felices de haberle brindado esta oprtunidad a nuestro hijo por que en un futuro podría tener mejores oprtunidades de las que tenemos en nuestro país.
                                    <i class="fas fa-quote-right text-mandys-pink ml-3" aria-hidden="true"></i>
                                </p>

                            </li>
                            <li class="mb-0">
                                <h3 class="h3-responsive text-center font-italic mb-0 text-ce-soir">Bianka
                                   y Fabian</h3>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </section>

    <!-- END VIDEOS SLIDER -->

    <!-- CTA SECTION -->

    <section class="my-5 container text-center">

        <h3 class="h3-responsive text-ce-soir mb-3">
            Conecta con Baby Passport, obtén tu guía gratuita sobre como dar a luz en Estados Unidos o consulta tu plan de pagos.
        </h3>

        <button class="btn btn-mandys-pink white-text btn-lg font-campton font-weight-bold btn-whats-price button-border">
            Consulta tu plan de pagos
        </button>

        <a href="https://medicalmeeting.clickfunnels.com/squeeze-page-28481773" class="btn btn-mandys-pink white-text btn-lg font-campton font-weight-bold button-border">
            Guía de información
        </a>


    </section>

    <!-- END CTA SECTION -->

     <!-- BLOG TITULE -->
     <section class="cities container-fluid pt-4">

        <h2 class="h2-responsive text-ce-soir text-center mb-1">BLOG PARA TI

        
        </h2>
        <div class="section-divider bg-mandys-pink my-3"></div>

    </section>
    <!-- BLOG TITULE -->


    <!-- BLOG POSTS -->
    <section class="container-fluid blogs my-0 my-lg-3">
        <div class="row justify-content-center justify-content-md-start justify-content-xl-start">
            @foreach ($blogs as $blog)
         
          @include('_partials/welcome/blog_item')
            @endforeach
        </div>
    </section>
    <!-- END BLOG POSTS -->

 <!-- COUNTERS 
    <div class="my-5 container text-center countups">

        <h1 class="my-5 text-center text-grey-suit">Familias como la tuya satisfechas en todo el mundo</h1>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <h2 class="display-2 text-mandys-pink mb1" id="partners-countup">30</h2>
                <p class="display-4 font-weight-bold text-mandys-pink">Socios</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <h2 class="display-2 text-ce-soir mb1" id="births-countup">6,000</h2>
                <p class="display-4 font-weight-bold text-ce-soir">Partos</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <h2 class="display-2 text-spray mb1" id="pacients-countup">6,200</h2>
                <p class="display-4 font-weight-bold text-spray">Pacientes</p>
            </div>
        </div>

    </div>-->
    <!-- END COUNTERS -->


@endsection()




@section('custom_scripts')
    <script async src="https://player.vimeo.com/api/player.js"></script>
    <script async type="text/javascript" src="{{asset(mix('/js/web/index.js'))}}"></script>
@endsection()
