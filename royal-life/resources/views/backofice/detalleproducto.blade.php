@extends('backofice.layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush

@section('content')
<body class="ml-auto">
@include('backofice.ui.estylos')
@include('backofice.ui.script')





<div class="fondo3 fondo0">
    <div class="container"  >
        <div class="row">
            <div class="col-sm-12 mt-5 mb-5">
                <h1 class="text-white"  style="font-size: 50px;"><strong> Producto </strong> </h1>
                <a class="text-white" href="{{route('inicio.index')}}"><strong> Inicio </strong></a><strong class="ml-1">
                    > </strong>
                <a style="color: #52CCA7" class="ml-1"><strong> Producto </strong></a>

            </div>
        </div>
    </div>
    </div>

<div class="fuente mx-auto">
<div class="container-fluid    mt-5">
    <div class="row mr-5 ml-5 mb-3">
      <div class=" cir col-sm-4">
            <div class="fondoProducto  shadow text-center " style="">
                @if($producto->img == null)
                <img class="o"
                 src="{{asset('assets/img/home/producto21.png')}}"
                 alt="Product Image">
         @else
               <img class="rounded-circle  text-center w-75 o "
                    src="{{ asset('storage/photo-producto/'.$producto->img) }}"
                    alt="Product Image"
                    style="">
         @endif
            </div>
        </div>

      <div class="col-sm-5 ">
       
        <form action="{{route('cart.GUEST')}}" method="POST">
          @csrf
          <input type="hidden" name="package_id" id="id" value="{{$producto->id}}">
          <input type="hidden" name="categories_id" id="categories_id" value="{{$producto->categories_id}}">
          <input type="hidden" name="monto" id="monto" value="{{$producto->price}}">
          <input type="hidden" name="name" id="name" value="{{$producto->name}}">
          <input type="hidden" name="categorianame" id="categorianame" value="{{$producto->getCategories->categories_name}}">


          <div class="card" style=" background:#FFFFFF;">
              <div class="textAlingComprar card-body textAling">
                <h5 class="card-title"><strong style="font-size: 30px">{{$producto->name}}</strong></h5>

                <h4>Precio:</h4>
                <p class="text-dark ">  <strong> ${{$producto->price}} </strong> </p>
                <h4>Cantidad:</h4>

                <button class=" Rangoprecio shadow zoomj custominput text-white"  onclick="handleClickResta()" type="button"><i class="fa fa-minus"></i></button>
                <input class="sinborde shadow  text-center text-dark" type="number" id="cantidad" name="cantidad" value="1" min="1" required style="width: 100px">
                <button class="Rangoprecio shadow zoomj custominput text-white" onclick="handleClickSuma()"  type="button"><i class="fa fa-plus"></i></button>

                <div class="action">
                    <button class="btn text-dark btn-custom mt-2  mb-2 zoom5"
                            type="submit"
                            name="btnAccion"
                            value="AGREGAR">
                    <i class="fa fa-shopping-cart text-dark zoom5"></i><strong> Comprar </strong></button>
                </div>
              </div>
            </div>
        </form>
         
      </div>

      <div class="col-sm-3">
        <div class="card " style=" background:#FFFFFF;">
            <div class=" ml-1 mr-1 card-body">
                <h6> <strong class="fuente"> Categorias </strong></h6>
                <hr class="hr">
                @foreach ( $categorias as $categories )
                <div class="form-check col-12 ">
                    <input class="form-check-input" type="checkbox" value="{{$categories->id}}"id="flexCheckDefault">
                    <label class="form-check-label mb-2"for="flexCheckDefault" style="">
                        <a class="s " href="{{ route('categorias.show', ['Categories' => $categories->id ]) }}">
                    <strong>  {{ ucfirst($categories->categories_name) }}</strong>
                        </a>
                    </label>
                </div>
                @endforeach
            </div>
          </div>
      </div>
    </div>
  </div>

  <div class="container-fluid ">
    <div class="row mr-5 ml-5 mb-5">
      <div class="col-sm-12">
         <div class="row">
              <div class="col-sm-12 ">
                <div class=" card "  style="background:#FFFFFF;   width: 18rem;">
                    <div class="card-body text-dark">
                        <h1 class=" mt-2 mb-2 textAling"><strong class=""> Descripcion del producto </strong></h1>
                        <p class="text-dark mb-2 " > {!! $producto->description !!} </p>
                    </div>
                </div>
              </div>
            </div>
      </div>
    </div>
  </div>


<div class="container-fluid " style=" background:#F0FFFA ">
    <div class="col-sm-6 m-1" >
        <h1 class="  mb-3 textAling m-5"><strong class="m"> Productos Relacionados </strong></h1>
    </div>
    <div class="ml-5 mr-5 row">
        @include('backofice.ui.relacionados')
    </div>
    </div>
</div>
  @endsection
