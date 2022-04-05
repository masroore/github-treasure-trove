<!-- Modal -->
<div class="modal fade" id="modalModalAprobar" tabindex="-1" role="dialog" aria-labelledby="modalModalAprobarTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="modalModalAprobarTitle">Aprobar Retiro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify">
                {{-- <div class="alert alert-primary" role="alert">
                    Intentos Fallidos {{session('intentos_fallidos')}}/3
                  </div> --}}
                <form action="{{route('settlement.process')}}" method="post">
                    @csrf
                    <input type="hidden" name="idliquidation" :value="idliquidacion">
                    <input type="hidden" name="action" value="aproved"> 
                    <input type="hidden" name="wallet"  :value="wallet">

                    <div class="form-group" >
                        <label for="">Codigo Correo</label>
                        <input type="text" name="correo_code" class="form-control" required>
                        <div class="col-12 text-center mt-1">
                            <button type="button" class="btn btn-info text'white" v-on:click='sendCodeEmail' v-if='idliquidacion == 0'>Enviar Codigo</button>
                            <span class='text-white' v-else>Codigo Enviado, tienes 30 min sino se cancelara el retiro automaticamente</span>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label for="">Codigo Google</label>
                        <input type="text" name="google_code" class="form-control" required>
                    </div>
                    
                    <div class="form-group text-center">
                        <button class="btn btn-primary">Aprobar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>