<!-- MODAL PARA RETIRAR SALDO DISPONILE -->

<div class="modal fade" id="modalSaldoDisponible" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Retiro</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="background: linear-gradient(90deg, rgba(172,118,19,1) 0%, rgba(214,168,62,1) 94%)">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form method="POST" action="{{route('retirarSaldo')}}">
            @csrf 
     
            <div class="modal-body">
               
                <div class="row">
                    <div class="col-12 mb-1" >
                        <label for="" class="col font-weight-bold text-white mr-3">Billetera</label>
                        <input required style="backoground: #5f5f5f5f;" class="form-control d-inline" name="wallet" type="text" value="">
                    </div>
                    <div class="col-12 mb-1">
                        <label for="" class="col font-weight-bold text-white mr-3">Disponible</label>
                        <input disabled style="backoground: #5f5f5f5f;" class="col form-control d-inline" type="text" value="{{Auth::user()->saldoDisponible()}}">
                    </div>
                    <div class="col-12 mb-1">
                        <label for="" class="col font-weight-bold text-white mr-3">Fee</label>
                        <input disabled style="backoground: #5f5f5f5f;" class="col form-control d-inline" type="text" value="{{ number_format(Auth::user()->getFeeWithdraw(), 2) }}">
                    </div>
                    <div class="col-12 mb-1">
                        <label for="" class="col font-weight-bold text-white mr-3">A recibir:</label>
                        <input disabled style="backoground: #5f5f5f5f;" class="form-control d-inline" type="text" value="{{ number_format(Auth::user()->totalARetirar(),2) }}">
                    </div>
                    <div class="col-12 mb-1" >
                        <label for="" class="col font-weight-bold text-white mr-3">Codigo Authenticador</label>
                        <input required style="backoground: #5f5f5f5f;" class="form-control d-inline" name="google_code" type="text" value="">
                    </div>
                    <div class="col-12 mb-1" >
                        <label for="" class="col font-weight-bold text-white mr-3">Codigo Correo</label>
                        <input required style="backoground: #5f5f5f5f;" class="form-control d-inline" name="correo_code" type="text" value="">
                        <a href="{{route('send-code-email')}}" class="btn btn-info mt-1 btn-block">Solicitar Codigo Correo</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
            <button type="submit" class="btn btn-primary">Retirar</button>
            </div>
        </form>
    </div>
    </div>
</div>
