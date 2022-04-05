@extends('backofice.layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush


@include('backofice.ui.estylos'){{--Estilos de la tienda--}}

@section('content')

<div class="img-head">
    <div class="texto-tienda">
        <strong>Tienda</strong>
     </div>
     <div class="texto-tiendaB d-flex">
        <a class="ml-auto text-white" href="{{route('inicio')}}"><strong> Inicio </strong></a><strong class="ml-1"> > </strong><p style="color: #52CCA7" class="ml-1"><strong>Tienda</strong></p>
    </div>
    <img src="{{asset('assets/img/home/formas_fondo3.png')}}" alt=""  style="height: 200px;width: 100%;">

</div>



<div class="container">
    <div class="row">

      <div class="col-sm-3 ctg" style="width: 1000px;">
       @include('backofice.ui.cardcategorias')
      </div>

      <div class="col-sm-9">
       @include('backofice.ui.productos')
      </div>

      <div class="container mt-5  ">
        <div class="ml-5 row">
          <div class="link ml-5 mb-2 pg">
            <div class="ml-1">
          {{$packages->links('pagination::bootstrap-4') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection
