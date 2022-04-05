<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="modalInfoTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="modalInfoTitle">Detalles Retiro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify">
                <h5 class="text-white">Billetera: <b v-text='wallet'></b></h5>
                <h5 class="text-white">Total a Recibir: <b>{{ number_format(Auth::user()->totalARetirar(),2) }}</b></h5>
                <div class="col-12 text-center">
                    <button class="btn btn-primary" v-on:click='openModalAprobar'>Continuar</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>