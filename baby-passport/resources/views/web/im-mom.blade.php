@extends('layouts.app')

@section('title')
    <title>BabyPassport | Procedimiento para dar a luz a tu bebé en Estados Unidos 100% legal</title>
@endsection


@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('content')



    <div class=" process-container pb-5">

        <div class="process-content py-5 py-xl-0">
            <h1 class="text-light text-shadow text-center">CONOCE EL PROCESO</h1>


            <div class="row justify-content-center">
                <div class="col-10">
                    <p class="mt-3 mb-1 text-light text-justify text-sm-center text-shadow font-medium">
                        Estos son los pasos que seguiremos juntos para que tu bebé obtenga su nacionalidad americana de
                        manera
                        exitosa.
                    </p>
                    <p class="mb-3 text-light text-justify text-sm-center text-shadow font-medium">
                        Para cualquier duda contáctanos.
                    </p>
                </div>
            </div>


            <!-- XLARGE DEVICES -->
            <div id="smartwizard" class="mt-5 d-none d-xl-block">
                <ul>
                    <li>
                        <a href="#step-1">
                            @include('_partials/svg_render',["path"=>"img/miscellaneous/pdf-text-file.svg","class"=>"step-icon"])
                            <br/>
                            <small>Descargar guía</small>
                        </a>
                    </li>
                    <li>
                        <a href="#step-2">
                            @include('_partials/svg_render',["path"=>"img/miscellaneous/enterprise.svg","class"=>"step-icon"])
                            <br/>
                            <small>Selecciona tu ciudad</small>
                        </a>
                    </li>
                    <li>
                        <a href="#step-3">
                            @include('_partials/svg_render',["path"=>"img/miscellaneous/add_woman.svg","class"=>"step-icon"])
                            <br/>
                            <small>Regístrate</small>
                        </a>
                    </li>
                    <li>
                        <a href="#step-4">
                            @include('_partials/svg_render',["path"=>"img/miscellaneous/credit-cards-payment.svg","class"=>"step-icon"])
                            <br/>
                            <small>Realiza el pago</small>
                        </a>
                    </li>

                    <li>
                        <a href="#step-5">
                            @include('_partials/svg_render',["path"=>"img/miscellaneous/phone-call.svg","class"=>"step-icon"])
                            <br/>
                            <small>LLamada seguimiento Baby Passport</small>
                        </a>
                    </li>
                </ul>

                <div class="container mx-auto">

                    <div id="step-1" class="">

                        <div class="row">
                            <div class="col-3">
                                @include('_partials/svg_render',["path"=>"img/miscellaneous/pdf-text-file.svg","class"=>"process-icon"])
                            </div>
                            <div class="col-9">
                                <h2 class="text-left text-light text-shadow">1. DESCARGA LA GUÍA PARA TENER A TU BEBÉ EN
                                    EU DE FORMA LEGAL.</h2>

                                <p class="mt-3 text-left text-light text-shadow">
                                    Descarga la guía Baby Passport para conocer el contexto legal bajo el cual se lleva
                                    a cabo nuestro servicio y resolver dudas frecuentes.
                                </p>

                                <a href="{{asset('img/miscellaneous/guia_mama.pdf')}}" download="guia_mama.pdf"
                                   class="btn btn-ce-soir btn-full-rounded p-2 p-lg-3 text-light text-center ">
                                    <i class="fas fa-file-pdf"></i> Descargar Guía Gratuita
                                </a>
                            </div>
                        </div>

                    </div>


                    <div id="step-2" class="">
                        <div class="row">
                            <div class="col-3">
                                @include('_partials/svg_render',["path"=>"img/miscellaneous/enterprise.svg","class"=>"process-icon"])
                            </div>
                            <div class="col-9">
                                <h2 class="text-left text-light text-shadow">2. BUSCA TU CIUDAD</h2>

                                <p class="mt-3 text-left text-light text-shadow">
                                    Selecciona la ciudad de tu preferencia.
                                </p>

                                <a href="{{route('web.getMomSearch')}}"
                                   class="btn btn-ce-soir btn-full-rounded p-2 p-lg-3 text-light text-center ">
                                    <i class="fas fa-city"></i> Ver ciudades
                                </a>
                            </div>
                        </div>
                    </div>


                    <div id="step-3" class="">
                        <div class="row">
                            <div class="col-3">
                                @include('_partials/svg_render',["path"=>"img/miscellaneous/add_woman.svg","class"=>"process-icon"])
                            </div>
                            <div class="col-9">
                                <h2 class="text-left text-light text-shadow">3. REGÍSTRATE</h2>

                                <p class="mt-3 text-left text-light text-shadow">
                                    Crea un usuario con tu correo electrónico y una contraseña para iniciar tu proceso.
                                </p>

                                <a href="{{route('web.getRegisterMom')}}"
                                   class="btn btn-ce-soir btn-full-rounded p-2 p-lg-3 text-light text-center ">
                                    <i class="fas fa-user-plus"></i> Registrarme
                                </a>
                            </div>
                        </div>
                    </div>


                    <div id="step-4" class="">
                        <div class="row">
                            <div class="col-3">
                                @include('_partials/svg_render',["path"=>"img/miscellaneous/credit-cards-payment.svg","class"=>"process-icon"])
                            </div>
                            <div class="col-9">
                                <h2 class="text-left text-light text-shadow">4. REALIZA EL PAGO.</h2>

                                <p class="mt-3 text-justify text-light text-shadow">
                                    La contratación del paquete medico de maternidad debe realizarse a más tardar en la
                                    semana 30 del embarazo, en caso contrario sera necesario un tramite adicional por
                                    encontrarse fuera de tiempo.
                                </p>

                                <a class="btn btn-ce-soir btn-medium btn-full-rounded"
                                   href="{{asset('img/miscellaneous/checklist-fisica.jpeg')}}"
                                   download="checklist-persona-fisica.jpeg">
                                    <i class="fas fa-download"></i> Descargar Checklist
                                </a>

                            </div>
                        </div>
                    </div>

                    <div id="step-5" class="">
                        <div class="row">
                            <div class="col-3">
                                @include('_partials/svg_render',["path"=>"img/miscellaneous/phone-call.svg","class"=>"process-icon"])
                            </div>
                            <div class="col-9">
                                <h2 class="text-left text-light text-shadow">5. LLAMADA SEGUIMIENTO BABY PASSPORT</h2>

                                <p class="mt-3 text-left text-light text-shadow">
                                    Un agente baby passport se contactará contigo para continuar con tu proceso.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END X-LARGE DEVICES-->

            <!--   XLARGE SHORTER DEVICES -->

            <div class="row justify-content-center d-flex d-xl-none">
                <div class="col-10 col-md-8 col-lg-10">
                    <div class="accordion" id="accordionExample">


                        @include('_partials/im_mom/accordion_item',[
                            'title'=>"1. Descargar guía",
                            "svg" =>"download",
                            "path"=>'img/miscellaneous/pdf-text-file.svg',
                            "copy"=>"<p>Descarga la guía Baby Passport para conocer el contexto legal bajo el cual se lleva a cabo
                                    nuestro servicio y resolver dudas frecuentes.</p>
                                    <a href=\"{{asset('img/miscellaneous/guia_mama.pdf')}}\" download='guia_mama.pdf' class='btn btn-ce-soir btn-full-rounded text-light text-center'>
                                        <i class='fas fa-file-pdf'></i> Descargar Guía Gratuita
                                    </a>
                                    "
                        ])


                        @include('_partials/im_mom/accordion_item',[
                            'title'=>"2. Selecciona tu ciudad",
                            "svg" =>"search",
                            "classIcon"=>'process-icon',
                            "path"=>'img/miscellaneous/enterprise.svg',
                            "copy"=>"
                                <p>Selecciona la ciudad de tu preferencia.</p>
                                       <a href='".route('web.getMomSearch')."' class='btn btn-ce-soir btn-full-rounded text-light text-center'>
                                        <i class='fas fa-city'></i> Ver ciudades
                                    </a>
                            "
                        ])

                        @include('_partials/im_mom/accordion_item',[
                            'title'=>"3. Regístrate",
                            "svg" =>"registro",
                            "path"=>'img/miscellaneous/add_woman.svg',
                            "copy"=>"
                                <p>Crea un usuario con tu correo electrónico y una contraseña para iniciar tu proceso.</p>
                                 <a href='".route('web.getRegisterMom')."'
                                   class=\"btn btn-ce-soir btn-full-rounded p-2 p-lg-3 text-light text-center \">
                                    <i class=\"fas fa-user-plus\"></i> Registrarme
                                </a>
                            "
                        ])

                        @include('_partials/im_mom/accordion_item',[
                            'title'=>"4. Realiza el pago",
                            "svg" =>"perfil",
                            "path"=>'img/miscellaneous/resume.svg',
                            "copy"=>"
                                 <p class=\"mt-3 text-justify text-grey-suit\">
                                    La contratación del paquete medico de maternidad debe realizarse a más tardar en la
                                    semana 30 del embarazo, en caso contrario sera necesario un tramite adicional por
                                    encontrarse fuera de tiempo.
                                </p>

                                <a class=\"btn btn-ce-soir btn-medium btn-full-rounded\"
                                   href=\"{{asset('img/miscellaneous/checklist-fisica.jpeg')}}\"
                                   download=\"checklist-persona-fisica.jpeg\">
                                    <i class=\"fas fa-download\"></i> Descargar Checklist
                                </a>


                            "
                        ])


                        @include('_partials/im_mom/accordion_item',[
                            'title'=>"5. Llamada seguimiento Baby Passport",
                            "svg" =>"paquete",
                            "path"=>'img/miscellaneous/stork.svg',
                            "copy"=>"
                                <p class=\"mt-3 text-left text-grey-suit\">
                                  Un agente baby passport se contactará contigo para continuar con tu proceso.
                                </p>

                                    "
                        ])


                    </div>
                </div>
            </div>


            <!-- END SHORTER XLARGE -->


        </div>
    </div>


@endsection()

@section('footer')
    @include('_partials/footer',["background"=>"bg-spray","button"=>"btn-ce-soir"])
@endsection

@section('custom_scripts')
    <script src="{{asset(mix('js/web/im.mom.js'))}}"></script>
@endsection

