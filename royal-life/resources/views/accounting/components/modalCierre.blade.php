<!-- Modal -->
<div class="modal fade" id="modalCierreComision" tabindex="-1" role="dialog" aria-labelledby="modalCierreComisionTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCierreComisionTitle">Cierre del (@{{DataCierre.paquete}})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form form-vertical" action="{{route('commission_closing.store')}}">
                    <div class="form-body">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="package_id" :value="DataCierre.package_id">
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="">Saldo Final Anterior</label>
                                    <input type="number" step="any" class="form-control" disabled :value="DataCierre.saldo_final">
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="">Saldo Inicial</label>
                                    <input type="number" step="any" name="s_inicial" class="form-control" required v-model="SaldoInicial">
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="">Ingreso</label>
                                    <input type="number" step="any" name="s_ingreso" class="form-control" readonly :value="DataCierre.ingreso">
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="">Saldo Final</label>
                                    <input type="number" step="any" name="s_final" class="form-control" readonly :value="saldoFinal">
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Guardar Cierre</button>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
