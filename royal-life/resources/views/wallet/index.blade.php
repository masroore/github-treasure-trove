@extends('layouts.dashboard')

{{-- contenido --}}
@section('content')
<div class="col-12">
    <div class="card bg-lp">
        <div class="card-content">
            <div class="card-body card-dashboard">
               <h1 class="text-white">Billetera</h1>
                <div class="float-right row no-gutters" style="width: 30%;">
                <div class="col-md-4 col-12">
                        <span class="font-weight-bold text-white">Saldo:</span>
                    </div>
                    <div class="col-md-4 col-12">
                        $ {{number_format($saldoDisponible,2)}}
                    </div>
                    <div class="col-12 col-md-4">
                            <button class="btn btn-primary" data-toggle="modal"
                            data-target="#modalSaldoDisponible">Retirar</button>
                    </div>
                </div>
                <div class="table-responsive"> 
                    @include('wallet.component.tableWallet')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('layouts.componenteDashboard.modalRetirar')
{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')
