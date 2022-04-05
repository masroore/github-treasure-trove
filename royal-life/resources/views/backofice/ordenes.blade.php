@extends('backofice.layouts.dashboard')
@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush
@section('content')
@include('backofice.ui.script')
@include('backofice.ui.carritoScript')

<style>
table {
  border-collapse: collapse;
  border-radius: 1em;
  overflow: hidden;
}

.statusCancelado{
  background: #fd7d8e;
  border-radius: 15px;
  border: 1.5px solid #e00d29;
  font-size: 14px !important;
  width: 90px!important;
  height: 25px!important;
}
.statusEspera{
  background: #8f8f8f;
  border-radius: 15px;
  border: 1px solid #696969;
  font-size: 14px !important;
  width: 90px!important;
  height: 25px!important;
}

.statusAprovado{
  background: #52CCA7;;
  border-radius: 15px;
  border: 1px solid #439c82;;
  font-size: 14px !important;
  width: 90px!important;
  height: 25px!important;
}
.p{
    position: relative;
    margin:auto;
    text-align:center!important;
}
</style>



<div class="carousel-inner">
    <img class="d-block w-100" src="{{asset('assets/img/home/formas_fondo3.png')}}" style="background: #173138;">
    <div class="container carousel-caption d-flex justify-content-start" style="top:90px;left: 7%;">
        <div class="row">
            <div class="col-md-6">
                <div class="text-left">
                    <h3 class="text-white" style="font-size: 50px;"><strong> Mis Compras </strong></h3>
                </div>
                <div class="text-left d-flex ml-1">
                    <a class="text-white" href="{{route('inicio.index')}}"><strong> Inicio </strong></a><strong class="ml-1">
                        > </strong>
                    <p style="color: #52CCA7" class="ml-1"><strong> ordenes </strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
<h1 class="text-center mt-5 " ><strong style=" color:#52CCA7; font-size: 50px;"> Lista de Compras </strong></h1>
    <div class="row">
      <div class="col-sm-12">

        <div class="card mt-5 mb-1 table-responsive" style="background: white">
            <table class="table text-dark col-sm-12">
                <thead class=" " style=" background: #52CCA7;">
                  <tr>
                    <th></th>
                    <th  ><h4><strong class=" text-white "> Producto </strong></h4></th>
                    <th  ><h4><strong class=" text-white "> Precio </strong></h4></th>
                    <th  ><h4><strong class=" text-white "> Cantidad</strong> </h4></th>
                    <th  ><h4><strong class=" text-white "> Total</strong></h4></th>
                    <th  ><h4><strong class=" text-white "> Estatus</strong></h4></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($producto as $item )
                  <tr>
                    <td>
                        @if($item->getPackageOrden->img == null)
                        <img class="o"

                        src="{{asset('assets/img/home/producto21.png')}}"
                        alt="Product Image"  height="100" width="100">

                        @else

                        <img src="{{ asset('storage/photo-producto/'.$item->getPackageOrden->img) }}" class="rounded ml-1" alt="" height="100" width="100">

                        @endif
                    </td>
                    <td><h5><strong class="p ml-1"> {{ucfirst($item->getPackageOrden->name)}}</strong></h5></td>
                    <td> <h5><strong class="p "> ${{$item->monto}} </strong></h5></td>
                    <td ><h5><strong class="p ml-3"> {{$item->cantidad}}</strong></h5></td>
                    <td><h5><strong class="p "> ${{$item->monto * $item->cantidad}}</strong></h5></td>
                    <td class="text-white">
                    @if($item->status == 2)
                     <div class="statusCancelado text-white text-center"> <strong > Cancelado </strong></div>
                     @endif

                    @if($item->status == 0)
                    <div class="statusEspera text-white text-center"> <strong >En espera</strong></div>
                    @endif

                    @if($item->status == 1)
                    <div class="statusAprovado text-white text-center"> <strong >Aprobado</strong></div>
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
   
   <div class="container mt-5  ">
            <div class=" row">
              <div class="link mb-2 pg ml-1">
                <div class="">
              {{ $producto->links('pagination::bootstrap-4') }}
                </div>
              </div>
            </div>
          </div>
@endsection
