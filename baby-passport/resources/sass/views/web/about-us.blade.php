@extends('layouts.app')



@section('title')
    <title>Baby Passport | Nosotros</title>
@endsection
@section('content')

<h1 class="text-center text-ce-soir" style="padding-top:7rem">¿Quieres saber cómo tener mas pacientes?</h1>
    <!-- ABOUT CONTAINER -->
    <section class=" mt-5 about-container">

        <div class="row justify-content-center justify-content-md-start">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">


                <div class="card rounded">
                    <div class="text-white rgba-white-strong p-4 z-depth-2">

                        <!--Header-->
                        <div class="text-center">
                            <h3 class="text-grey-suit mb-5 mt-4 font-weight-bold">
                                Forma parte del equipo de <span class="text-center text-ce-soir font-weight-bold">
                                <strong> BABY PASSPORT</strong></span>
                            </h3>
                        </div>

                        <div class="md-form">
                            <input type="text" id="name-doctor" class="form-control">
                            <label for="form-name" class="">¿ Cúal es tu nombre?</label>
                        </div>

                        <!--Body-->
                        <div class="md-form">
                            <input type="text" id="speciality" class="form-control">
                            <label for="form-speciality" class="">¿ Cuál es tu especialidad?</label>
                        </div>

                        <div class="md-form">
                            <input type="text" id="city" class="form-control">
                            <label for="form-city" class="">¿De qué ciudad nos visitas?</label>
                        </div>


                        <!--Grid row-->
                        <div class="row d-flex align-items-center">

                            <!--Grid column-->
                            <div class="text-center mb-3 col-md-12">
                                <button type="submit"
                                        class="btn btn-whatsdoctor btn-ce-soir btn-block btn-rounded z-depth-1 waves-effect waves-light">
                                        ¡Quiero información!
                                </button>
                            </div>
                            <!--Grid column-->

                        </div>
                        <!--Grid row-->

                    </div>
                </div>
            </div>
        </div>


    </section>


    <!--WHY JOIN US -->
    <section class="why-join-us container">
        <div class="row">
            <div class="col-12 col-lg-12 mt-5 mb-3 px-5">
                <h2 class="h2-responsive text-spray text-center font-weight-bold">
                    ¿Por qué formar parte de Baby Passport?
                </h2>

                <p class="mt-3 lead text-justify text-grey-suit">
                <span class="justify-copy">Por dos simples razones, la principal es por que ganaras una comisión por referir a tus pacientes que quieran tener a su bebé en USA. 
                Y lo mejorde todo es que serás parte de la red con los mejores ginecológos a nivel internacional y nacional.
               </span>
                </p>
            </div>
        </div>
    </section>


    <!-- STEPS -->
<section class="steps container-fluid mt-2 mb-5 pb-5">
        <h2 class="h1-responsive text-ce-soir text-center mb-lg-5">Conoce nuestro proceso</h2>
<div class="row">
    <div class="col-12 col-lg-4 my-4">
         <!-- card1 -->
        <div class="flip-card mx-auto">
            <div class="flip-card-inner">
              <div class="flip-card-front bg-spray" style="padding-top:8rem">

                <h2 class="h3-responsive text-white">¡Conocenos!</h2>
                
              </div>
              <div class="flip-card-back bg-spray" style="padding-top:6rem">
                <h4 class="h4-responsive mx-3">Recibe una llamada para conocer la información y un curso para saber como funciona baby passport.</h4>
              </div>
            </div>
          </div>
   </div>
   <div class=" col-12 col-lg-4 my-4">
    <!-- card2 -->
   <div class="flip-card mx-auto">
       <div class="flip-card-inner">
         <div class="flip-card-front bg-ce-soir">
         
          <h2 class="h3-responsive text-white px-3" style="padding-top:6rem"> Refiere a tu paciente o anunciate con babypassport</h2>
         </div>
         <div class="flip-card-back bg-ce-soir px-2 px-lg-4">
            <h5 class="h5-responsive mx-3" style="padding-top:1.6rem">Una vez que tu paciente decida dar a luz con Baby Passport, seguiras en contacto con ella por si necesita resolver alguna duda médica durante el viaje.</h5>
            <h5 class="h5-responsive mx-3">Támbien puedes anunciarte en Baby Passport para que encuentres a tus nuevos pacientes cercanos a tu zona.</h5>
         </div>
       </div>
     </div>
</div>

<div class=" col-12 col-lg-4 my-4">
    <!-- card3 -->
   <div class="flip-card mx-auto">
       <div class="flip-card-inner">
         <div class="flip-card-front bg-mandys-pink">
            <h2 class="h3-responsive text-white" style="padding-top:8rem"> Recibe tu comisión </h2>
         
         </div>
         <div class="flip-card-back  bg-mandys-pink" style="padding-top:6rem">
            <h4 class="h5-responsive mx-3">Una vez que tu paciente haya finalizado su proceso en Baby Passport, recibe tu comisión</h4>
         </div>
       </div>
     </div>
</div>
</div>

</section>

    <!-- CTA SECTION -->

    <div class="about-cta-container pt-5 mt-lg-5">

        <div class="row flex-column-reverse flex-lg-row align-items-center">

            <div class="col-12 col-lg-7 mt-3 mt-lg-0 text-center">
                <h2 class="display-5 text-spray ml-lg-5">¿Listo para ser un aliado Baby Passport?</h2>

                <button class="btn ml-lg-5 btn-whats-doctor-aliado btn-lg btn-ce-soir white-text font-medium waves-effect waves-light">¡Comenzar ahora!</button>
            </div>
            <div class="col-8 col-sm-3 mr-lg-5">

                <img class="img img-fluid" src="http://localhost/Baby/baby_passport/img/miscellaneous/doctor-sub.png" alt="Afiliarme Baby Passport">
            </div>
        </div>
    </div>
    <!-- END CTA SECTION -->


@endsection


@section('custom_scripts')
    <script async type="text/javascript" src="{{asset(mix('/js/web/about-us.js'))}}"></script>
@endsection
