<!-- Card deck -->
<div class="card-deck mt-3">

    <!-- Card -->
    <div class="card mb-4">

        <!--Card image-->
        <div class="card-title">
            <img class="img-fluid" src="{{asset('img/miscellaneous/logopaypal.png')}}" alt="Baby Passport Pago"
                 style="max-height: 200px;">
        </div>

        <!--Card content-->
        <div class="card-body" id="paypal-button-container">


            <!--Title-->
            <form
                    class="w3-container w3-display-middle w3-card-4 "
                    method="POST" id="paypalPaymentForm"
                    action="{{route('web.postPayWithPaypal')}}">

                @csrf

                @include("_partials/payment/totalTaxes")


                <div class="form-check mt-1 mb-3">
                    <input class="form-check-input addTaxes" type="checkbox" value="">
                    <label class="form-check-label" for="defaultCheck1">
                        ¿Requieres factura?
                    </label>
                </div>


                <input type="hidden" name="cart_id"
                       value="{{$maternityPackage  ? $maternityPackage["id"]:''}}">
                <input type="hidden" name="subtotal"
                       value="{{$maternityPackage  ? $maternityPackage["subtotal"]:''}}">
                <input type="hidden" name="iva" value="0">
                <input type="hidden" name="amount"
                       value="{{$maternityPackage  ? $maternityPackage["subtotal"]:''}}">
                <input type="hidden" name="item"
                       value="{{$maternityPackage  ? $maternityPackage["description"]:''}}">

                <button type="submit" class="btn btn-ce-soir text-white btn-lg ">
                    <i class="fas fa-money-bill-alt"></i> PAGAR
                </button>
            </form>

        </div>

    </div>
    <!-- Card -->

    <!-- Card -->
    <div class="card mb-4">

        <!--Card image-->
        <div class="card-title p-5">
            <img class="img-fluid" src="{{asset('img/miscellaneous/banregio.png')}}" alt="Card image cap">
        </div>

        <!--Card content-->
        <div class="card-body">

            <!--Title-->
            @include("_partials/payment/totalTaxes")


            <p class="card-text">
                <a href="#"
                   class="openBankReferenceModal btn btn-ce-soir btn-lg text-white"
                   id="openPaymentModal">
                    <i class="fas fa-file-pdf"></i> Descargar ficha
                </a>
            </p>

        </div>

    </div>
    <!-- Card -->

</div>
<!-- Card deck -->

{{--
<div class="row align-items-center my-3">


    <div class="col-12 col-md-4">

        <div class="card pay-method-card shadow border-ce-soir">
            <div class="card-body d-flex flex-column">
                <img src="{{asset('img/miscellaneous/paypal-logo.png')}}" alt="" class="img-fluid">


                <form
                        class="w3-container w3-display-middle w3-card-4 "
                        method="POST" id="paypalPaymentForm"
                        action="{{route('web.postPayWithPaypal')}}">

                    @csrf

                    @include("_partials/payment/totalTaxes")


                    <div class="form-check mt-1 mb-3">
                        <input class="form-check-input addTaxes" type="checkbox" value="">
                        <label class="form-check-label" for="defaultCheck1">
                            ¿Requieres factura?
                        </label>
                    </div>


                    <input type="hidden" name="cart_id"
                           value="{{$maternityPackage  ? $maternityPackage["id"]:''}}">
                    <input type="hidden" name="subtotal"
                           value="{{$maternityPackage  ? $maternityPackage["subtotal"]:''}}">
                    <input type="hidden" name="iva" value="0">
                    <input type="hidden" name="amount"
                           value="{{$maternityPackage  ? $maternityPackage["subtotal"]:''}}">
                    <input type="hidden" name="item"
                           value="{{$maternityPackage  ? $maternityPackage["description"]:''}}">

                    <button type="submit" class="btn btn-ce-soir btn-full-rounded btn-lg btn-block ">
                        <i class="fas fa-money-bill-alt"></i> PAGAR
                    </button>
                </form>


            </div>
        </div>
    </div>

    @if(auth()->user()->name=='Areli Martinez Boveda')


        <div class="col-12 col-md-4 mt-3 mt-md-0">
            <div class="card pay-method-card shadow border-ce-soir">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-ce-soir">TARJETAS DE CRÉDITO Y DÉBITO</h5>

                    <img src="{{asset('img/miscellaneous/cards1.png')}}" alt="" class="img-fluid">
                    <img src="{{asset('img/miscellaneous/cards2.png')}}" alt="" class="img-fluid">


                    <div class="my-3">
                        @include("_partials/payment/totalTaxes")

                    </div>


                    <button type="button" class="btn btn-ce-soir btn-full-rounded btn-full-rounded btn-lg btn-block"
                            data-target="#cardPaymentModal"
                            data-toggle="modal">
                        <i class="fas fa-money-bill-alt"></i> PAGAR
                    </button>


                </div>
            </div>
        </div>
    @endif

    <div class="col-12 col-md-4 mt-3 mt-md-0">

        <div class="card pay-method-card shadow border-ce-soir">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-ce-soir">REFERENCIA BANCARIA</h5>

                <img src="{{asset('img/miscellaneous/banregio.png')}}" alt="" class="img-fluid">

                @include("_partials/payment/totalTaxes")

                <p class="card-text">
                    <a href="#"
                       class="openBankReferenceModal btn btn-ce-soir btn-full-rounded btn-lg btn-block"
                       id="openPaymentModal">
                        <i class="fas fa-file-pdf"></i> Descargar ficha
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>

--}}

<p class="text-white red lead  font-weight-bold shadow p-3">
    La contratación del paquete medico de maternidad debe realizarse a más tardar la semana 30 del embarazo, en caso
    contrario será necesario un trámite adicional por encontrarse fuera de tiempo.
</p>

<p class="text-ce-soir">
    * Para cualquier duda consulta nuestras políticas de cancelación.
</p>
