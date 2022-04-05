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
<script src="{{asset('assets/js/category.js')}}"></script>
@endpush

@section('content')
<div id="category">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="col-12">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalNewCategories">
                            <i class="fa fa-plus">Nuevo Grupo</i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Img</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr class="text-center">
                                    <td>{{$category->id}}</td>
                                    <td>
                                        <img src="{{asset('media/'.$category->img)}}" alt="" height="100" width="100">
                                    </td>
                                    <td>{{$category->name}}</td>
                                    <td>{!!$category->description!!}</td>
                                    <td>
                                        @if ($category->status == 1)
                                            <span class="badge badge-success text-white">Activo</span>
                                        @else
                                            <span class="badge badge-warning text-white">Desactivado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info" onclick="vm_category.getEditData('{{$category->id}}')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="vm_category.deleteData('{{$category->id}}')">
                                            <form action="{{route('group.destroy', $category->id)}}" method="post" id="delete{{$category->id}}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <i class="fa fa-trash"></i>
                                        </button>
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
    {{-- Modal Nueva Categoria --}}
    @include('manager_services.categories.components.modalNew')
    {{-- Modal Editar Categoria --}}
    @include('manager_services.categories.components.modalEdit')
</div>

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')
{{-- permite llamar a las opciones para editor --}}
@include('layouts.componenteDashboard.optionSummernote')

@endsection