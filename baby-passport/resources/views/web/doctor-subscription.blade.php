@extends('layouts.app')


@section('title')
    <title>Baby Passport | Suscripción a Contenido</title>
@endsection()

@section('content')

    <section
            class="container-fluid py-0 px-5 bg-section"
    >
        <div class="container">
            <!--SUSCRIPTION CONTAINER-->





            <div
                    class="row justify-content-center align-items-center mt-5"
                    id="suscription-container"
            >
                <div class="col-12 col-lg-6 text-center">

                    <div class="row justify-content-center text-center">
                        <div class="col-12 col-lg-8 text-center">

                            <img class="img-fluid logo" src="{{asset('img/logos/MM1-azul.jpg')}}"
                                 alt="Medical Meeting"/>
                        </div>
                    </div>

                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-12 col-lg-3 text-center">


                            <img class="img-fluid mt-3" src="{{asset('img/logos/fertcolor.jpg')}}"
                                 alt="Como atender a mas pacientes"/>


                        </div>
                        <div class="col-12 col-lg-4 text-center">
                            <img class="img-fluid mt-3" src="{{asset('img/logos/logo-78ded4.jpg')}}"
                                 alt="Como atender a mas pacientes"/>
                        </div>
                    </div>

                    <img src="{{asset('img/miscellaneous/doctor-sub.jpg')}}" alt="Como atender a mas pacientes"
                         class="img-fluid w-75 mt-3">
                </div>


                <div class="col-12   col-lg-6 mt-5 mt-lg-0">

                    <div class="subscription-errors">

                    </div>

                    <form
                            action="https://www.paypal.com/cgi-bin/webscr"
                            method="post"
                            id="general-form"
                            data-parsley-validate="true"
                            accept-charset="UTF-8"
                            autocomplete="off"
                    >

                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="DTCJ3Y5QAHMEW">


                        <div
                                class="bg-spray rounded text-center text-light suscription-banner shadow px-3 py-1 mb-4"
                        >
                            ¡<b>Aprovecha</b> nuestra promoción y suscríbete por solo $99.00 pesos
                            mensuales!
                        </div>

                        <!--NAME INPUT-->
                        <div class="form-group">
                            <input
                                    type="text"
                                    required
                                    class="form-control btn-full-rounded"
                                    autocomplete="off"
                                    placeholder="Nombre completo"
                                    name="user[name]"
                            />
                        </div>
                        <!--END NAME INPUT-->

                        <!--EMAIL INPUT-->
                        <div class="form-group">
                            <input
                                    type="email"
                                    required
                                    class="form-control btn-full-rounded"
                                    autocomplete="off"
                                    placeholder="Correo electrónico"
                                    name="user[email]"
                            />
                        </div>
                        <!--END EMAIL INPUT-->

                        <h2 class="text-center text-grey-suit general-title font-weight-bold my-2">Datos Generales</h2>

                        <!--ADDRESS INPUT-->
                        <div class="form-group">
                            <input
                                    type="text"
                                    required
                                    class="form-control btn-full-rounded"
                                    autocomplete="off"
                                    placeholder="Calle, Nº Exterior, Colonia"
                                    name="user_address[address]"
                            />
                        </div>
                        <!--END ADDRESS INPUT-->

                        <!--STATE INPUT-->
                        <div class="form-group">
                            <input
                                    type="text"
                                    required
                                    class="form-control btn-full-rounded"
                                    autocomplete="off"
                                    placeholder="Estado/Provincia"
                                    name="user_address[state]"
                            />
                        </div>
                        <!--END STATE INPUT-->

                        <!--ZIP INPUT-->
                        <div class="form-group">
                            <input
                                    type="text"
                                    required
                                    class="form-control btn-full-rounded"
                                    autocomplete="off"
                                    placeholder="Código Postal"
                                    name="user_address[zip_code]"
                            />
                        </div>
                        <!--END ZIP INPUT-->

                        <!--COUNTRY INPUT-->
                        <div class="form-group">
                            <input
                                    type="text"
                                    required
                                    class="form-control btn-full-rounded"
                                    placeholder="País"
                                    autocomplete="off"
                                    name="user_address[country]"
                            />
                        </div>
                        <!--END COUNTRY INPUT-->

                        <div class="row text-center my-4">
                            <div class="col-12">
                                <input type="image"
                                       src="https://www.paypalobjects.com/es_XC/MX/i/btn/btn_subscribeCC_LG.gif"
                                       border="0" name="submit"
                                       alt="PayPal, la forma más segura y rápida de pagar en línea." id="paypalSubmit">
                                <img alt="Paypal" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif"
                                     width="1" height="1">
                            </div>
                        </div>

                        <!--LEGEND-->

                        <p class="text-grey-suit font-weight-bolder text-justify mt-4 legend">
                            El costo normal de las suscripciones a este tipo de contenido es de
                            $400.00 pesos mensuales en el mercado. Obtén un descuento
                            <b>MASIVO</b> de $301.00 pesos. Suscríbete a nuestra red Baby Passport
                            por <b>sólo</b> $99.00 pesos. Tu información está segura.
                        </p>
                        <!--END LEGEND-->
                    </form>
                </div>
            </div>

            <!--END SUSCRIPTION CONTAINER-->
        </div>

    </section>

@endsection()


@section('custom_scripts')

    <script src="{{asset(mix('/js/web/subscription.js'))}}"></script>

@endsection()
