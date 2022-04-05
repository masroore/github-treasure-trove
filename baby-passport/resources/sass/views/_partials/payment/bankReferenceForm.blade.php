<!-- Modal -->
<div class="modal fade" id="bankReferenceModal" tabindex="-1" role="dialog" aria-labelledby="paymentModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-ce-soir" id="exampleModalCenterTitle">Descargar Referencia para
                    depósito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-12 bg-white btn-full-rounded p-3 text-center">


                        <form
                                class="w3-container w3-display-middle w3-card-4 "
                                method="POST" id="bankReferenceForm"
                                action="{{route('web.downloadBankReference')}}">

                            @csrf


                            <div class="form-check mt-1 mb-3">


                                <h4 class="mb-1"><span class="badge badge-ce-soir">SUBTOTAL</span></h4>
                                <p class="my-1" id="subtotalLabel"></p>

                                <h4 class="my-1"><span class="badge badge-ce-soir">IVA</span></h4>
                                <p class="my-1" id="ivaLabel"></p>

                                <h4 class="my-1"><span class="badge badge-ce-soir">TOTAL A PAGAR</span></h4>
                                <p class="mt-1" id="totalLabel"></p>


                                <input class="form-check-input invoiceCheck" type="checkbox">
                                <label class="form-check-label" for="defaultCheck1">
                                    ¿Requieres factura?
                                </label>


                            </div>

                            <a id="referenceData" data-subtotal="" data-iva="" data-total=""></a>

                            <input type="hidden" name="subtotal">
                            <input type="hidden" name="iva">
                            <input type="hidden" name="amount">
                            <input type="hidden" name="exchange_rate">
                            <input type="hidden" name="item">
                            <input type="hidden" name="cart_id">


                            <button type="button" class="btn btn-ce-soir btn-full-rounded btn-medium"
                                    id="submitBankReference">
                                <i class="fas fa-download"></i> Descargar
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
