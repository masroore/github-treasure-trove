@extends('layouts.dashboard')

@section('content')
<div id="logs-list">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <h1 class="text-white">Inversiones</h1>

                    @if(auth()->user()->admin == 1)
                    <div class="">

                        <button class="btn btn-primary bg-white mt-1 waves-effect waves-light text-white ml-auto" data-toggle="modal" data-target="#modalPorcentajeGanancia">Cambiar %</button>

                    </div>

                    @endif
                    <div>
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100 text-white ">

                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>id</th>
                                    <th>Correo</th>
                                    {{-- <th>Paquete</th> --}}
                                    <th>Inversion</th>
                                    <th>Ganancia</th>
                                    {{-- <th>Capital</th> --}}
                                    <th>Progreso</th>
                                    {{-- <th>Ganancia acumulada</th> --}}
                                    {{-- <th>Porcentaje fondo</th> --}}
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($inversiones as $inversion)

                                @php
                                $ganancia = $inversion->capital - $inversion->invertido;

                                $porcentaje = ($ganancia / $inversion->invertido) * 100;
                                @endphp
                                <tr class="text-center text-white">
                                    <td>{{$inversion->id}}</td>
                                    <td>{{$inversion->correo}}</td>
                                    {{-- <td>{{$inversion->getPackageOrden->getGroup->name }} -
                                    {{$inversion->getPackageOrden->name}}</td> --}}
                                    <td>$ {{number_format($inversion->invertido, 2, ',', '.')}}</td>
                                    <td>$ {{number_format($inversion->ganacia, 2, ',', '.')}}</td>
                                    {{-- <td>$ {{number_format($inversion->capital, 2, ',', '.')}}</td> --}}
                                    <td>{{number_format($inversion->progreso() * 2,2, ',', '.')}} %</td>
                                    {{-- <td>$ {{number_format($inversion->ganancia_acumulada,2, ',', '.')}}</td> --}}
                                    {{-- <td>{{number_format($inversion->porcentaje_fondo,2, ',', '.')}} %</td> --}}
                                    <td>{{date('Y-m-d', strtotime($inversion->created_at))}}</td>
                                    <td>
                                        @if($inversion->status == 1)
                                            Activo
                                        @elseif($inversion->status == 2)
                                            Inactivo
                                        @endif
                                    </td>
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

<!-- MODAL PARA ACTUALIZAR PORCENTAJE DE GANANCIA -->
@if(auth()->user()->admin == 1)
    <div class="modal fade" id="modalPorcentajeGanancia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content bg-lp" >
            <div class="modal-header bg-lp" >
            <h5 class="modal-title text-white" id="exampleModalLabel">Porcentaje de ganancia</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="background: linear-gradient(90deg, rgba(17,38,44,1) 0%, rgba(54,99,112,1) 94%)">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{route('updatePorcentajeGanancia')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body bg-lp" >
                    <label for="porcentaje_ganancia" class="text-white">Ingrese el nuevo porcentaje de ganancia</label>
                    <input type="number" step="any" name="porcentaje_ganancia" class="form-control" required style="background: #5f5f5f5f; color: white; border: 2px solid #66FFCC !important">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endif

@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')
