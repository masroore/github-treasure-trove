@extends('layouts.dashboard')

@section('content')
    <div class="col-12" >
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <h1 class="text-white">Lista de Paquetes</h1>
                        
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">

                            <thead class="">
                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>

                            <tbody>
                                 @foreach ($package as $item)
                                <tr class="text-center text-white">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')
