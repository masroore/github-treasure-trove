@extends('backofice.layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush

@push('custom_css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;500&display=swap');

    .custominput {
        border: 0;
    }




    .cheking {
        position: relative;
        padding-left: -400px;

    }

    .hr {
        position: absolute;
        width: 100%;
    }

    .container {
        display: flex;
    }

    .btn-custom {
        width: 220px;
        height: 45px;
        left: 153px;
        background: #67FFCC;
        border-radius: 7px;
    }

    .fuente {
        font-family: 'Montserrat', sans-serif;
        font-style: normal;

    }

    .tamañofuente {
        font-size: 15px;
    }

    .orden {
        position: relative;
        margin-top: -19px;
    }

    .requerido {
        color: red;
        margin-left: 1px;
        top: -1px;
        font-size: 15px;
    }

    .button {
        z-index: 10;
    }
    .zoomc:hover {

-webkit-transform:scale(1.05);
-moz-transform:scale(1.05);
-ms-transform:scale(1.05);
-o-transform:scale(1.05);
transform:scale(1.05);

-webkit-transition:all 0.3s ease;
-moz-transition:all 0.3s ease;
-o-transition:all 0.3s ease;
-ms-transition:all 0.3s ease;

border-color: #66FFCC !important;
color: black!important;
box-shadow: 0 8px 25px -8px #66ffcc;
background-color: #66FFCC;
}
.zoomc:active {

-webkit-transform:scale(1);
-moz-transform:scale(1);
-ms-transform:scale(1);
-o-transform:scale(1);
transform:scale(1);

-webkit-transition:all 0.3s ease;
-moz-transition:all 0.3s ease;
-o-transition:all 0.3s ease;
-ms-transition:all 0.3s ease;

border-color: #66FFCC !important;
color: rgb(255, 255, 255)!important;
box-shadow: 0 8px 25px -8px #66ffcc;
background-color: #66FFCC;
}

</style>
@endpush


@section('content')

@if(Auth::user() == true )




<div class="fondo3 fondo0">
<div class="container"  >
    <div class="row">
        <div class="col-sm-12 mt-5 mb-5 ml-5">
            <h1 class="text-white"  style="font-size: 50px;"><strong>Checkout </strong> </h1>
            <a class="text-white" href="{{route('shop.backofice')}}"><strong> Producto  </strong></a><strong class="ml-1">
                > </strong>
            <a style="color: #52CCA7" class="ml-1"><strong> Tienda </strong></a>

        </div>
    </div>
</div>
</div>


<div class="mt-5 ml-10 pb-5 container ">
    <form method="GET" action="{{route('orden')}}" class="credit-card-div fuente">
        @csrf
    <div class="row d-flex">
    <div class="col-5  ml-5 " style="background: #ffffff;">

            <div class="panel panel-default ">
                <div class="panel-heading">
                    <h2> <strong>Detalles de facturacion </strong> </h2>

                    <br>
                    <div class="row ">
                        <div class="col-sm-6 col-sm-6 col-xs-3 form-group ">
                            <span class="help-block text-muted text textcustom  control-span">Nombres<sup
                                    class="requerido">*</sup>
                            </span>
                            <input name="name" type="text" class="custominput text-dark mt-1 form-control"
                                style="background:  #F6F6F7;" value="{{$user != null ? $user->name : ''}}" />
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-3">
                            <span class="help-block text-muted textcustom mb-1">Apellidos <sup
                                    class="requerido">*</sup></span>
                            <input name="lastname" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:   #F6F6F7;" value="{{$user != null ?$user->last_name : ''}}" />

                                @error('lastname')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Pais<sup class="requerido">*</sup></span>
                            <input name="country" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('country')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Direccion<sup class="requerido">*</sup></span>
                            <input name="address" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Pueblo/Ciudad<sup class="requerido">*</sup></span>
                            <input name="city" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('city')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Estado<sup class="requerido">*</sup></span>
                            <input name="state" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('state')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <br>

                    <div class="row ">
                        <div class="col-md-6 col-sm-6 col-xs-3">
                            <span class="help-block text-muted ">Email<sup class="requerido">*</sup></span>
                            <input name="email" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7;" value="{{$user != null ?$user->email : ''}}"/>
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>

                        <br>

                        <div class="col-md-6 col-sm-6 col-xs-3">
                            <span class="help-block text-muted ">Telefono<sup class="requerido">*</sup></span>
                            <input name="phone" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:   #F6F6F7;" value="{{$user != null ?$user->whatsapp : ''}}" />
                                @error('phone')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
    </div>


    <div class="mt-2 ml-5 mb-5 cheking fuente col-5">
        <div class="col-10  ml-5 text-dark ">
            <div class="row orden">

                <table class="table table-borderless factura">
                    <tr>
                        <h2 class="ml-1 "><strong>Tu orden <strong></h2>
                        <th class=""><strong class="tamañofuente">Productos </strong></th>
                        <th></th>
                        <th></th>
                        <th class="text-right "><strong class="tamañofuente">Subtotal</strong></th>
                    </tr>
                    <tbody>
                        <tr>
                        </tr>
                        @foreach ($producto as $item)
                        <tr>

                            <td>
                                <h6>{{$item->name}}</h6>
                            </td>
                            <td></td>
                            <td></td>
                            <td class="text-right">${{$item->price}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <th><strong class="tamañofuente"> Subtotal </strong></th>
                        <th></th>
                        <th></th>
                        <th class="text-right"> <strong class="tamañofuente">${{$suma}}</strong></th>
                    </tr>
                    <tr>
                        <th class="text-left">
                            <h6><strong>Iva </strong></h6>
                        </th>
                        <th></th>
                        <th></th>
                        <th class="text-right ">
                            <h6><strong>15%<strong></h6>
                        </th>
                    </tr>
                    <tfoot>
                        <tr>
                            <th class="text-left" >
                                <h6><strong>Total + Iva </strong></h6>
                            </th>
                            <th></th>
                            <th></th>
                            <th class="text-right" name="cantidad">
                                <h6><strong>${{($suma+($suma * 15/100))}}<strong></h6>
                            </th>
                        </tr>

                    </tfoot>

                </table>

                <hr class="hr">

                <button class=" zoomc form-group mt-5 mt-5 btn btn-custom text-dark button" style="left: 150px;">

                    <input class="custominput" value="Realizar pedido" type="submit" style="background: #67FFCC">
                    </button>


            </div>
        </div>
    </div>

</div>
</form>
</div>


@else



<div class="img-head">
    <div class="texto-tienda">
        <strong>Checkout</strong>
    </div>
    <div class="texto-tiendaB d-flex">
        <a class="ml-1 text-white" href="{{route('shop.backofice')}}"><strong> Producto </strong></a><strong class="ml-1"> > </strong>
        <p style="color: #52CCA7" class="ml-1"><strong>Checkout</strong></p>
    </div>
    <img src="{{asset('assets/img/home/formas_fondo3.png')}}" alt="" style="height: 200px;width: 100%;">

</div>


<div class="mt-5 ml-10 pb-5 container ">
    <form method="GET" action="{{route('orden')}}" class="credit-card-div fuente">
        @csrf
    <div class="row d-flex">
    <div class="col-5  ml-5 " style="background: #ffffff;">

            <div class="panel panel-default ">
                <div class="panel-heading">
                    <h2> <strong>Detalles de facturacion </strong> </h2>

                    <br>
                    <div class="row ">
                        <div class="col-sm-6 col-sm-6 col-xs-3 form-group ">
                            <span class="help-block text-muted text textcustom  control-span">Nombres<sup
                                    class="requerido">*</sup>
                            </span>
                            <input required name="name" type="text" class="custominput text-dark mt-1 form-control"
                                style="background:  #F6F6F7;" value="" />
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-3">
                            <span class="help-block text-muted textcustom mb-1">Apellidos <sup
                                    class="requerido">*</sup></span>
                            <input name="lastname" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:   #F6F6F7;" value="" />

                                @error('lastname')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Pais<sup class="requerido">*</sup></span>
                            <input name="country" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('country')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Direccion<sup class="requerido">*</sup></span>
                            <input name="address" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Pueblo/Ciudad<sup class="requerido">*</sup></span>
                            <input name="city" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('city')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12 pad-adjust">
                            <span class="help-block text-muted ">Estado<sup class="requerido">*</sup></span>
                            <input name="state" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7" />
                                @error('state')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <br>

                    <div class="row ">
                        <div class="col-md-6 col-sm-6 col-xs-3">
                            <span class="help-block text-muted ">Email<sup class="requerido">*</sup></span>
                            <input name="email" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:  #F6F6F7;" value=""/>
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>

                        <br>

                        <div class="col-md-6 col-sm-6 col-xs-3">
                            <span class="help-block text-muted ">Telefono<sup class="requerido">*</sup></span>
                            <input name="phone" type="text" class="form-control custominput  text-dark mt-1"
                                style="background:   #F6F6F7;" value="" />
                                @error('phone')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{--FORMULARIO DE LOGIN--}}
            <div class="mt-2">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalLogin">Login</button>
            </div>

    </div>


    <div class="mt-2 ml-5 mb-5 cheking fuente col-5">
        <div class="col-10  ml-5 text-dark ">
            <div class="row orden">
                <table class="table table-borderless factura">
                    <tr>
                        <h2 class="ml-1 "><strong>Tu orden <strong></h2>
                        <th class=""><strong class="tamañofuente">Productos </strong></th>
                        <th></th>
                        <th></th>
                        <th class="text-right "><strong class="tamañofuente">Subtotal</strong></th>
                    </tr>
                    <tbody>
                        <tr>
                        </tr>
                        @foreach ($producto as $item )
                        <tr>

                            <td>
                                <h6>{{$item->name}}</h6>
                            </td>
                            <td></td>
                            <td></td>
                            <td class="text-right">${{$item->subtotal}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <th><strong class="tamañofuente"> Subtotal </strong></th>
                        <th></th>
                        <th></th>
                        <th class="text-right"> <strong class="tamañofuente">${{$suma}}</strong></th>
                    </tr>
                    <tr>
                        <th class="text-left">
                            <h6><strong>Iva </strong></h6>
                        </th>
                        <th></th>
                        <th></th>
                        <th class="text-right ">
                            <h6><strong>15%<strong></h6>
                        </th>
                    </tr>
                    <tfoot>
                        <tr>
                            <th class="text-left" >
                                <h6><strong>Total + Iva </strong></h6>
                            </th>
                            <th></th>
                            <th></th>
                            <th class="text-right" name="cantidad">
                                <h6><strong>${{($suma+($suma * 15/100))}}<strong></h6>
                            </th>
                        </tr>

                    </tfoot>

                </table>
                <hr class="hr">

                <button class=" zoomc form-group mt-5 mt-5 btn btn-custom text-dark button" style="left: 150px;">

                    <input class="  custominput" value="Realizar pedido" type="submit" style="background: #67FFCC">
                    </button>


            </div>
        </div>
    </div>

</div>
</form>
</div>

@endif
    <!-- Modal -->
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalLoginLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
               <form method="POST" action="{{route('users.login')}}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="InputEmail1">Email</label>
                    <input type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp" name="email">
                </div>
                <div class="form-group">
                    <label for="InputPassword">Password</label>
                    <input type="password" class="form-control" id="InputPassword" name="password">
                </div>
                <div>
                    <a class="">¿No tienes una cuenta ? Rgistrate aqui</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Iniciar Session</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    @endsection
