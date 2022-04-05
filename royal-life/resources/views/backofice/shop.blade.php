@extends('backofice.layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush



@include('backofice.ui.estylos')

@section('content')


<div class="fondo3 fondo0">
<div class="container"  >
    <div class="row">
        <div class="col-sm-12 mt-5 mb-5">
            <h1 class="text-white"  style="font-size: 50px;"><strong> TIENDA </strong> </h1>
            <a class="text-white" href="{{route('inicio.index')}}"><strong> Inicio </strong></a><strong class="ml-1">
                > </strong>
            <a style="color: #52CCA7" class="ml-1"><strong> Tienda </strong></a>

        </div>
    </div>
</div>
</div>


<div class="container">
    <div class="row">
      <div class="col-sm-3">
       @include('backofice.ui.cardcategorias')
      </div>

<div class="col-sm-9">
       @include('backofice.ui.productos')

<div class="container mt-5  ">
    <div class="link1 row">
      <div class="link mb-2 pg">
        <div class="">
      {{$packages->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
  </div>



 @endsection

