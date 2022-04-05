<!-- Modal -->
<div class="modal fade" id="cardPaymentModal" role="dialog" aria-labelledby="cardPaymentModal"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-ce-soir" id="exampleModalCenterTitle">Pago con Tarjeta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form id="cardPaymentForm"
                      data-parsley-validate="true"
                      accept-charset="UTF-8"
                      autocomplete="off"
                      data-action="{{route('web.postOpenPay')}}"
                      method="POST">

                    @csrf

                    <input type="hidden" name="cart_id" value="{{$maternityPackage  ? $maternityPackage["id"]:''}}">

                    <input type="hidden" name="token_id" id="token_id"/>

                    <input type="hidden" name="description"
                           value="{{$maternityPackage  ? $maternityPackage["description"]:''}}">

                    <input type="hidden"
                           name="subtotal"
                           value="{{$maternityPackage  ? $maternityPackage["subtotal"]:''}}"
                           id="subtotal"/>

                    <input
                            type="hidden"
                            name="iva"
                            value="0"
                            id="iva"/>

                    <input type="hidden"
                           name="total"
                           value="{{$maternityPackage  ? $maternityPackage["total"]:''}}"
                           id="total"/>


                    <input
                            type="hidden"
                            name="use_card_points"
                            id="use_card_points"
                            value="false"
                    />


                    <div class="container-fluid">


                        <div class="row">
                            <!-- ITEM DATA -->
                            <div class="col-12 col-xl-5">

                                <div class="card payment-card">
                                    <h3 class="card-header bg-ce-soir text-light">Datos del Paquete</h3>
                                    <div class="card-body">

                                        <div class="row text-center align-items-center">
                                            <div class="col-2">
                                                <img src="{{asset('img/miscellaneous/MM3-azul.png')}}" alt=""
                                                     class="img-fluid">

                                            </div>
                                            <div class="col-10">
                                                <h5 class="text-ce-soir">Turismo Médico Digital S.A.P.I. de
                                                    C.V.</h5>
                                            </div>
                                        </div>


                                        <table class="table table-hover mt-3">

                                            <tbody>

                                            <tr>
                                                <td class="text-right" colspan="2">
                                                    @include("_partials/payment/totalTaxes")
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>¿Requiere factura?</td>
                                                <td>
                                                    {{Form::select(null,["no"=>'No','si'=>'Sí'],'no',["class"=>"form-control addTaxes"])}}
                                                </td>
                                            </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END ITEM DATA -->


                            <div class="col-12 col-xl-7">


                                <div class="alert alert-danger btn-full-rounded d-none pay-errors my-3">

                                </div>


                                <div class="card payment-card">
                                    <h3 class="card-header bg-ce-soir text-light">Pago con Tarjeta de
                                        Crédito/Débito</h3>
                                    <div class="card-body">


                                        <div class="row text-center">
                                            <div class="col-12 col-lg-5 ">
                                                <h5 class="text-ce-soir">Tarjetas de crédito</h5>
                                                <img src="{{asset('img/miscellaneous/cards1.png')}}"
                                                     alt="tarjetas_credito" class="img-fluid">
                                            </div>
                                            <div class="col-12 col-lg-7 mt-3 mt-lg-0">
                                                <h5 class="text-ce-soir">Tarjetas de débito</h5>
                                                <img src="{{asset('img/miscellaneous/cards2.png')}}"
                                                     alt="tarjetas_debito" class="img-fluid">
                                            </div>
                                        </div>


                                        <div class="form-group row mt-5">
                                            <div class="col-12 col-xl-6">
                                                <!-- NAME -->
                                                <div class="form-group">
                                                    <label for="owner_name">Nombre del Titular</label>
                                                    <input type="text" class="form-control btn-full-rounded"
                                                           data-openpay-card="holder_name"
                                                           placeholder="Como aparece en la tarjeta" required>
                                                </div>
                                                <!-- END NAME -->
                                            </div>
                                            <div class="col-12 col-xl-6">
                                                <!-- CARD NUMBER -->
                                                <div class="form-group">
                                                    <label for="owner_name">No. Tarjeta</label>
                                                    <input type="text" class="form-control btn-full-rounded"
                                                           data-openpay-card="card_number"
                                                           placeholder="**********8764" required>
                                                </div>
                                                <!-- END CARD NUMBER -->
                                            </div>
                                        </div>


                                        <div class="form-group row">

                                            <!--CVV -->
                                            <div class="col-12 col-xl-6">
                                                <div class="row">
                                                    <div class="col-12 col-xl-5">
                                                        <label for="owner_name">CVV</label>
                                                        <input type="text" class="form-control btn-full-rounded"
                                                               placeholder="***" required data-openpay-card="cvv2">
                                                    </div>
                                                    <div class="col-12 col-xl-7 align-self-end mt-3 mt-xl-0 text-center">
                                                        <img src="{{asset('img/miscellaneous/cvv.png')}}" alt="">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END CVV -->

                                            <!--EXPIRE DATE --->
                                            <div class="col-12 col-xl-6 mt-3 mt-xl-0">

                                                <div class="form-row">
                                                    <div class="col-12"><label>Fecha de expiración</label></div>

                                                    <div class="col">
                                                        <input type="text" placeholder="Mes (MM)"
                                                               class="form-control btn-full-rounded"
                                                               required="" data-openpay-card="expiration_month"
                                                               pattern="^(0?[1-9]|1[012])$">
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" placeholder="Año (YY)"
                                                               class="form-control btn-full-rounded"
                                                               required="" data-openpay-card="expiration_year"
                                                               pattern="^2?[1-9]$"
                                                        >
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- END EXPIRE DATE -->
                                        </div>


                                        <div class="row mt-4 justify-content-center justify-content-lg-end align-items-center">
                                            <div class="col-12 col-lg-6 border-right">
                                                <h5 class="text-ce-soir">Transacciones realizadas vía:</h5>
                                                <img src="{{asset('img/miscellaneous/openpay.png')}}"
                                                     alt="open pay" class="img-fluid">
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <p>
                                                    Tus pagos se realizan de forma segura con encriptación de 256
                                                    bits.
                                                    <img src="{{asset('img/miscellaneous/security.png')}}"
                                                         alt="security" class="img-fluid">
                                                </p>
                                            </div>
                                        </div>


                                        <div class="row text-center mt-3">
                                            <div class="col-12">
                                                <button
                                                        id="payment-button"
                                                        class="btn btn-ce-soir btn-medium btn-full-rounded"
                                                        type="submit"
                                                >
                                                    <i class="fas fa-credit-card"></i> Pagar
                                                </button>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
