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
                                    {{-- <th>Kyc</th> --}}
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

                                    {{-- @if ($item->dni != NULL && $item->status == '0')
                                    <td><span class="text-primary">Verificar</span></td>
                                    @elseif ($item->dni == NULL)
                                    <td>No Disponible</td>
                                    @elseif ($item->dni != NULL && $item->status == '1')
                                    <td>Verificado</td>
                                    @endif --}}

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
                                    
                                    {{-- @if ($item->dni != NULL && $item->status == 0)
                                     <a href="{{ route('users.show-user',$item->id) }}" class="btn btn-warning text-bold-600"><i class="fa fa-check-square-o "></i></a>
                                    @endif --}}
                                    
                                    @if(Auth::user()->id == $item->id)
                                    <a href="{{ route('profile') }}" class="btn btn-secondary text-bold-600"><i class="fa fa-pencil"></i></a>
                                    @else
                                    <a href="{{ route('users.edit-user',$item->id) }}" class="btn btn-secondary text-bold-600"><i class="fa fa-pencil"></i></a>
                                    
                                    
                                    <form action="{{route('impersonate.start', $item)}}" method="POST" class="btn">
                                        @csrf
                                        <button type="submit" class="btn btn-primary text-bold-600">
                                            <i class="fa fa-eye"></i>

                                        </button>

                                     </form>

                                    {{-- <button class="btn btn-danger" onclick="vm_ordenFollowers.deleteData('{{$item->id}}')">
                                        <form action="{{route('users.destroy-user', $item->id)}}" method="post" id="delete{{$item->id}}">
                                            @csrf
                                            @method('DELETE')admin
                                        </form>
                                        <i class="fa fa-trash"></i>
                                    </button> --}}
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

