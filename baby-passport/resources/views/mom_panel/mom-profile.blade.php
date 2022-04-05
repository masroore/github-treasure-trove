@extends('layouts.mom_panel ')

@section('title')
    <title>BabyPassport | Perfil </title>
@endsection

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection


@section('content')


    @include("_partials.payment.cardPaymentModal")
    @include("_partials/payment/bankReferenceForm")
    @include("_partials/payment/voucherModal")
    @include("_partials/payment/historyModal")
    @include("_partials/payment/cardPaymentModal")



    <div class="pb-lg-5 profile container">


        <h2 class="h2-responsive text-center text-ce-soir">
            Bienvenida a Baby Passport, completa los siguientes pasos para proceder al pago
            de tu paquete de maternidad en Estados Unidos.
        </h2>

        <div class="row my-3">
            <div class="col-12">
                @include("_partials/error_handling",["variable"=>"success","color"=>'ce-soir'])
                @include("_partials/error_handling",["variable"=>"error","color"=>'error'])
            </div>
        </div>


        <div class="card">
            <div class="card-body">

                <!-- FORM STEP-->
                <div id="smartwizard">
                    <!-- FORM STEP NAVIGATION -->
                    <ul class="nav nav-tabs flex-column flex-sm-row justify-content-sm-around">
                        <li>
                            <a href="#step-1">1. Información General</a>
                        </li>
                        <li>
                            <a href="#step-2">2. Paquete de maternidad</a>
                        </li>
                        <li>
                            <a href="#step-3">3. Pago</a>
                        </li>
                        <li>
                            <a href="#step-4">4. Confirmación de Pago</a>
                        </li>

                    </ul>
                    <!-- END FORM STEP NAVIGATION-->
                    <!-- FORM STEP CONTENT -->
                    <div>

                        <div id="step-1">
                            <div class="row justify-content-center">
                                <div class="col-10 px-3">
                                    @include("_partials/mom_profile/mom_info")
                                </div>
                            </div>
                        </div>

                        <div id="step-2">

                            <div class="row justify-content-center">
                                <div class="col-10 px-3 my-3">
                                    @include("_partials/mom_profile/cart")
                                </div>
                            </div>


                        </div>

                        <div id="step-3">

                            <div class="row justify-content-center">
                                <div class="col-10 px-3 my-3 text-center">
                                    @include("_partials/mom_profile/payment")
                                </div>
                            </div>

                        </div>
                        <div id="step-4">

                            <div class="row justify-content-center my-5">
                                <div class="col-12 col-lg-8">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item"
                                                id="receiptIframe"
                                                src="{{$receiptUrl != null ?$receiptUrl:''}}"
                                                allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!--END FORM STEP CONTENT-->
                </div>
                <!-- END FORM STEP -->
            </div>
        </div>

    </div>



    <a id="profileData"
       data-process_step="{{$user->step}}"
       data-maternity_package="{{json_encode($maternityPackage)}}">
    </a>
@endsection


@section('custom_scripts')
    <!-- <script src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script> -->

    <script src="https://www.paypal.com/sdk/js?client-id=AbPT8-jx0UIfloYxWtxjpM5yA6DJJyGHNV-ihSeC59xfOllNlhP9vNyqkSyxWO2bR7bamvRUhqCRfF6p"></script>
    <script>

        paypal.Buttons({
            createOrder: function (data, actions) {
                // Set up the transaction
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '15'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function (details) {
                    // Show a success message to your buyer
                    alert('Transaction completed by ' + details.payer.name.given_name);
                });
            }
        }).render('#paypal-button-container');

    </script>

    <script src="{{asset(mix('js/mom_panel/payment.js'))}}"></script>
    <script src="{{asset(mix('js/mom_panel/openpay.errors.js'))}}"></script>
    <script src="{{asset(mix('/js/mom_panel/mom.profile.js'))}}"></script>
@endsection


