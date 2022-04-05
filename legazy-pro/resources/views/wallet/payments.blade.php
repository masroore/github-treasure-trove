@extends('layouts.dashboard')

@section('content')
<div id="logs-list">
    <div class="col-12">
        <div class="card" style="background: #1b1b1b;">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                      <h1 class="text-white">Retiros</h1>
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100 text-white ">
                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">                                
                                    <th>ID</th>
                                    <th>Fecha</th>                          
                                    <th>Billetera</th>
                                    <th>Hash</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($payments as $item)
                                <tr class="text-center text-white">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>{{$item->wallet_used}}</td>
                                    <td>{{$item->hash}}</td>
                                    <td>{{$item->monto_bruto}}</td>
                                    @if ($item->status == '0')
                                    <td>En espera</td>
                                    @elseif($item->status == '1')
                                    <td>Pagado</td>
                                    @elseif($item->status == '2')
                                    <td>Cancelado</td>
                                    @endif
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


