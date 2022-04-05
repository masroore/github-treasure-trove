@extends('layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/librerias/emojionearea.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush

{{-- permite llamar las librerias montadas --}}
@push('page_js')
<script src="{{asset('assets/js/librerias/vue.js')}}"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
<script src="{{asset('assets/js/librerias/emojionearea.min.js')}}"></script>
@endpush

@push('custom_js')

{{-- <script src="{{asset('assets/js/ordenFollowers.js')}}"></script> --}}
@endpush

@section('content')

<div id="record">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive ">
                        <h1 class="text-white">Lista de Usuarios</h1>
                        
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100 text-white ">
                            
                            <thead class="">
                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Perfil</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>

                            <tbody>
                                 @foreach ($user as $item)
                                <tr class="text-center text-white">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->fullname}}</td>
                                    <td>{{ $item->email}}</td>
                                    <td>{{ $item->username}}</td>
                                    @if ($item->admin == '1')
                                    <td>Administrador</td>
                                    @else
                                    <td>Normal</td>
                                    @endif
                                    

                                    @if ($item->status == '0')
                                    <td>Inactivo</td>
                                    @elseif($item->status == '1')
                                    <td>Activo</td>
                                    @elseif($item->status == '2')
                                    <td>Suspendido</td>
                                    @elseif($item->status == '3')
                                    <td>Bloquiado</td>
                                    @elseif($item->status == '4')
                                    <td>Caducado</td>
                                    @elseif($item->status == '5')
                                    <td>Eliminado</td>
                                    @endif
                                    <td>{{ $item->created_at}}</td>
                                    <td>
                                        <a class="text-white btn btn-warning" href="{{route('user.authentication', ['Reiniciado', $item->id])}}">Reiniciar QR</a>
                                        @if ($item->activar_2fact > 0)
                                            @if ($item->activar_2fact == 1)
                                            <a class="text-white btn btn-danger" href="{{route('user.authentication', ['Desactivado', $item->id])}}">Desactivar 2fact</a>    
                                            @else
                                            <a class="text-white btn btn-success" href="{{route('user.authentication', ['Activado', $item->id])}}">Activar 2fact</a>
                                            @endif
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

@endsection
{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')

