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
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <h1>Lista de Paquetes</h1>
                        
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">

                            <thead class="">
                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                 @foreach ($services as $item)
                                <tr class="text-center">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->price}}</td>
                                   {{--    <td class="btn btn-relief-success">

                                 <a href="{{route('shop.procces',$item->id)}}">buy</a>

                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <form action="{{route('shop.procces', $item->id)}}" method="POST" target="_blank">
                    <div>

                        @csrf
                        <input type="hidden" name="idproduct" id="product_id">

                        <div class="row">
                            <div class="col-12 mb-1">
                                <label for="Nombre"></label>
                                <br>
                                <span id="name"> </span>

                            </div>

                            <button type="submit" class="btn btn-relief-success">comprar</button>
                        </form>






            </div>
        </div>
    </div>
</div>

@endsection
{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')


