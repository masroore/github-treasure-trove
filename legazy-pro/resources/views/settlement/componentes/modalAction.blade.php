<!-- Modal -->
<div class="modal fade" id="modalModalAccion" tabindex="-1" role="dialog" aria-labelledby="modalModalAccionTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document" style="background: #141414;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModalAccionTitle" v-text="(StatusProcess == 'reverse') ? 'Reservar Liquidacion' : 'Aprobar Liquidacion'"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify">
                <form action="{{route('settlement.process')}}" method="post">
                    @csrf
                    <input type="hidden" name="idliquidation" :value="ComisionesDetalles.idliquidaction">
                    <input type="hidden" name="action" :value="StatusProcess">
                    <h5>Usuario: <strong v-text="ComisionesDetalles.fullname"></strong></h5>
                    <h5>Total: <strong v-text="ComisionesDetalles.total"></strong></h5> 

                    <div class="form-group" v-if="StatusProcess == 'aproved'">
                        <label for="">Hash</label>
                        <input type="text" name="hash" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Comentario</label>
                        <textarea name="comentario" class="form-control" :required="(StatusProcess == 'reverse') ? true : false"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary" v-text="(StatusProcess == 'reverse') ? 'Reservar' : 'Aprobar'"></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>