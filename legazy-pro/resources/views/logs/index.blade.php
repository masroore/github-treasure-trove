@extends('layouts.dashboard')

@section('content')
<div id="logs-list">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">                                
                                    <th>ID</th>
                                    <th>Usuario</th>                          
                                    <th>ID de Transación</th>
                                    <th>Metodo de Pago</th>
                                    <th>Monto (Comision Incluida)</th>
                                    <th>Estado</th>
                                    <th>Fecha de Creación</th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($logs as $item)
                                <tr class="text-center">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->getUser->fullname}}</td>
                                    <td>{{$item->id_transacion}}</td>

                                    @if ($item->metodo_pago == 'Stripe')
                                    <td><img src="{{asset('assets/img/sistema/stripe1.png')}}" height="40" width="80"></td>
                                    @elseif($item->metodo_pago == 'Skrill')
                                    <td><img src="{{asset('assets/img/sistema/skrill1.png')}}" height="20" width="60"></td>
                                    @elseif($item->metodo_pago == 'Payu')
                                    <td><img src="{{asset('assets/img/sistema/payu1.png')}}" height="50" width="90"></td>
                                    @elseif($item->metodo_pago == 'Coinbase')
                                    <td><img src="{{asset('assets/img/sistema/coinbase1.png')}}" height="40" width="110"></td>
                                    @endif
                                    
                                    <td>{{$item->saldo}}</td>

                                    @if ($item->estado == '0')
                                    <td> <a class=" btn btn-info text-white text-bold-600">Esperando</a></td>
                                    @elseif($item->estado == '1')
                                    <td> <a class=" btn btn-success text-white text-bold-600">Aprobado</a></td>
                                    @elseif($item->estado == '2')
                                    <td> <a class=" btn btn-danger text-white text-bold-600">Cancelado</a></td>
                                    @endif

                                    <td>{{$item->fecha_creacion}}</td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')


