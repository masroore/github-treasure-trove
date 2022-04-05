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

<div class="carousel-inner">
    <img class="d-block w-100" src="{{asset('assets/img/home/formas_fondo3.png')}}" style="background: #173138;">
    <div class="container carousel-caption d-flex justify-content-start" style="top:90px;left: 9%;">
        <div class="row">
            <div class="col-md-6">
                <div class="text-left">
                    <h3 class="text-white" style="font-size: 50px;"><strong> Producto </strong></h3>
                </div>
                <div class="text-left d-flex ml-1">
                    <a class="text-white" href="{{route('inicio')}}"><strong> Inicio </strong></a><strong class="ml-1">
                        > </strong>
                    <p style="color: #52CCA7" class="ml-1"><strong> Producto </strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Product Detail Start -->
    <div class="container  ml-auto">
    <div class="  ml-auto fuente" >
        <div class="">
            <div class="row  ">
                <div class="col-sm-8">
                    <div class="">
                        <div class="row align-items-center mt-2">
                            <div class="col-sm-5 ">
                             <form action="{{route('cart.post')}}" method="POST">
                                @csrf
                                <div class="fondoProducto shadow  product-slider-single normal-slider text-center ">
                                    <input type="hidden" name="package_id" value="{{$producto->id}}">
                                    <input type="hidden" name="categories_id" value="{{$producto->categories_id}}">
                                    <input type="hidden" name="monto" value="{{$producto->price}}">


                                    @if($producto->img == null)
                                    <img class="o"
                                     src="{{asset('assets/img/home/producto21.png')}}"
                                     alt="Product Image">
                             @else
                                   <img class="rounded-circle o text-center w-75 "
                                        src="{{ asset('storage/photo-producto/'.$producto->img) }}"
                                        alt="Product Image"
                                        style="">
                             @endif
                                </div>
                                <div class="product-slider-single-nav normal-slider">

                                </div>
                            </div>
                            <div class="col-sm-7 mt-2 " style="max-width: 35rem;  min-width: 300px;">
                                <div class="product-content card " style="background:#FFFFFF;  ">
                                    <div class="title ml-3  mt-1 fuente"> <h2><strong>{{$producto->name}}</strong></h2></div>

                                    <div class="price ml-3">
                                        <h4>Price:</h4>
                                        <p class="text-dark "> <span> <strong> ${{$producto->price}} </strong> </span></p>
                                    </div>
                                    <div class="quantity ml-3">
                                        <h4>Quantity:</h4>
                                        <div class="sumador ml-2">
                                            <button class="Rangoprecio shadow zoom4 custominput "  onclick="handleClickResta()" type="button"><i class="fa fa-minus"></i></button>
                                            <input class="sinborde shadow  text-center text-dark" type="number" id="cantidad" name="cantidad" value="1" min="1" required>
                                            <button class="Rangoprecio shadow zoom4 custominput" onclick="handleClickSuma()"  type="button"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="action">
                                        <button class="btn text-dark btn-custom mt-2 ml-3 mb-2 zoom5" type="submit">
                                        <i class="fa fa-shopping-cart text-dark"></i> Comprar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>



                                <div class="container">
                                    <div class="row">
                                      <div class="col-sm-12 mt-5">

                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                              <h5 class="card-title">Card title</h5>
                                              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                                            </div>
                                          </div>


                                        <div class=" card "  style="background:#FFFFFF;   width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">Product description</h5>
                                                <p class="card-text text-dark mb-2 "> {!! $producto->description !!} </p>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>



                    <div class=" mt-3 mb-3 ancho"  style="background: rgb(255, 255, 255);">
                        <div class="">
                            <h1 class="ml-3 mt-2 "><strong class=""> Productos Relacionados </strong></h1>
                        </div>

                        <div class="row  ">

                            <div class="" >
                                <div class="container ">

                                </div>
                                <div class="row d-flex mb-4">

                                   @include('backofice.ui.relacionados')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Side Bar Start -->
                <div class="col-lg-4 sidebar ">
                    <div class="row card col-7  ml-2 mt-5 " style="background:#ffffff; top: -15px; width: 400px;" >
                        <div class="row card mt-2 " style="background:#ffffff; width: 160px;">
                             <h6> <strong class="fuente "> Categorias </strong></h6>
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
    </div>
    <!-- Product Detail End -->

    <!-- Brand Start -->


</body>
@endsection

