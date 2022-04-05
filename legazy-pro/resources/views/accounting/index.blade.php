@extends('layouts.dashboard')

@section('content')
{{-- permite llamar las librerias montadas --}}
@push('page_js')
<script src="{{asset('assets/js/librerias/vue.js')}}"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
@endpush

@push('custom_js')
<script src="{{asset('assets/js/accounting.js')}}"></script>
@endpush

<div id="cierre_comision">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">                                
                                   <th>Grupo</th>
                                   <th>Paquete</th>
                                   <th>Ingreso</th>
                                   <th>Accion</th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($ordenes as $orden)
                                <tr class="text-center">
                                    <td>
                                        {{$orden->grupo}}
                                    </td>
                                    <td>
                                        {{$orden->paquete}}
                                    </td>
                                    <td>
                                        {{$orden->ingreso}}
                                    </td>
                                    <td>
                                        @if ($orden->cerrada == 0)
                                        <button class="btn btn-info" onclick="vm_cierreComision.cerrarComisionProducto({{$orden->package_id}})">Cerrar Compras</button>
                                        @else
                                            Cerrada
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
    {{-- Modal cierre --}}
    @include('accounting.components.modalCierre')
</div>
@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')


