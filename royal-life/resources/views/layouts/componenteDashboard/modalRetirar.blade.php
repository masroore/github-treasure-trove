<!-- MODAL PARA RETIRAR SALDO DISPONILE -->

<div class="modal fade" id="modalSaldoDisponible" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Retiro</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="background: linear-gradient(90deg, rgba(17,38,44,1) 0%, rgba(54,99,112,1) 94%)">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form method="POST" action="{{route('retirarSaldo')}}">
            @csrf 
     
            <div class="modal-body text-center">
               
                <div class="row">
                    <div class="col-12 mb-1">
                        <div class="row mb-0 justify-content-center" style="font-size: 1.5em;">
                            <div class="col-2">
                                <label for="" class="col font-weight-bold text-white mr-3">Monto:</label>
                            </div>
                            <div class="col-8">
                                 <input disabled style="backoground: #5f5f5f5f;" class="col form-control w-50 d-inline" type="text" value="{{Auth::user()->saldoDisponible()}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-1">

                        <div class="row mb-0 justify-content-center" style="font-size: 1.5em;">
                            <div class="col-2">
                                <label for="" class="col font-weight-bold text-white mr-3">Fee:</label>
                            </div>
                            <div class="col-8">
                                 <input disabled style="backoground: #5f5f5f5f;" class="col form-control w-50 d-inline" type="text" value="{{ number_format(Auth::user()->getFeeWithdraw(), 2) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-1">
                        <div class="row mb-0 justify-content-center" style="font-size: 1.5em;">
                            <div class="col-2">
                                <label for="" class="col font-weight-bold text-white mr-3">A recibir:</label>
                            </div>
                            <div class="col-8">
                                <input disabled style="backoground: #5f5f5f5f;" class="form-control w-50 d-inline" type="text" value="{{ number_format(Auth::user()->totalARetirar(),2) }}">
                            </div>
                        </div>
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
