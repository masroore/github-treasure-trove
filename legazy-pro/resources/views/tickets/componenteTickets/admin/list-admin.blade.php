@extends('layouts.dashboard')

@section('content')

<div id="record">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <h1 class="text-white">Historial de Tickets</h1>
                        
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Usuario</th>

                                    <th>Email</th>
                                    <th>Estado</th>                                 
                                    {{-- <th>mensaje</th> --}}
                                    <th>Prioridad</th>
                                    <th>fecha de creacion</th>
                                    <th>Accion</th>
                                </tr>

                            </thead>

                            <tbody>

                                 @foreach ($ticket as $item)
                                <tr class="text-center text-white">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->getUser->fullname}}</td>
                                    <td>{{ $item->getUser->email}}</td>
                

        
                                    @if ($item->status == '0')
                                    <td> <a class=" btn btn-success text-white text-bold-600">Abierto</a></td>
                                    @elseif($item->status == '1')
                                    <td> <a class=" btn btn-danger text-white text-bold-600">Cerrado</a></td>
                                    @endif
                                    
                                    @if ($item->priority == '0')
                                    <td> <a class="text-uppercase">Alto</a></td>
                                    @elseif($item->priority == '1')
                                    <td> <a class="text-uppercase">Medio</a></td>
                                    @elseif($item->priority == '2')
                                    <td> <a class="text-uppercase">Bajo</a></td>
                                    @endif
                                    
                                    <td>{{ $item->created_at}}</td>
                                    <td><a href="{{ route('ticket.edit-admin',$item->id) }}" class="btn btn-primary text-bold-600">Revisar</a></td>
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


