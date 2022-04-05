@extends('layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush

{{-- permite llamar las librerias montadas --}}
@push('page_js')
<script src="{{asset('assets/js/librerias/vue.js')}}"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
@endpush

@push('custom_js')
<script src="{{asset('assets/js/liquidation.js')}}"></script>
@endpush

@section('content')
<div id="settlement">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                      <h1 class="text-white">Liquidaciones por Generar</h1>
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-white bg-purple-alt2">
                                    {{-- <th> Seleccionar Todo </th>                              --}}
                                    <th>ID Usuario</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Total Comision</th>
                                    <th>Estado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comisiones as $comision)
                                    <tr class="text-center text-white">
                                        {{-- <td>
                                            <input type="checkbox" value="item.id" name="listComisiones[]">
                                        </td> --}}
                                        <td>{{$comision->iduser}}</td>
                                        <td>{{$comision->getWalletUser->fullname}}</td>
                                        <td>{{$comision->getWalletUser->email}}</td>
                                        <td>{{$comision->total}}</td>
                                        <td>{{$comision->getWalletUser->status}}</td>
                                        <td>
                                            <a onclick="vm_liquidation.getDetailComision({{$comision->iduser}})" class="btn btn-primary">
                                                <i class="feather icon-eye"></i>
                                            </a>
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
    @include('settlement.componentes.modalDetalles', ['all' => true])
</div>
@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')


