@extends('layouts.auth')

<style>
    html{
        overflow: hidden;
    }
</style>

@section('content')
<!-- BEGIN: Content-->
<div class="auth-wrapper auth-v2">
        <div class="auth-inner row m-0">

        
        <!-- Left bg-->
        <div class="d-none d-lg-flex col-lg-4 align-items-center legazy_bg">
            <div class="align-items-center justify-content-center">
                <div class= "row justify-content-center">
                    <div class="col-auto">
                         <img src="{{ asset('assets/img/legazy_pro/logo.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- Login-->
        <div class="d-flex col-lg-6 align-items-center auth-bg p-lg-4">
            
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2">
                    <h2 class="card-title fw-bold mb-1 text-white">{{$username}}, bienvenido a Legazy Pro</h2>
                    <a href="{{$ruta}}"><h4>Para validar su correo presione aquí. </h4></a>

                    <h4>Si al presionar no lo redirige a ningún sitio, puede copiar y pegar el siguiente enlace en su navegador:</h4>
                    <a href="{{$ruta}}"><h4>{{$ruta}}</h4></a>

                    <p>Este es su enlace para verificar su correo</p>
                    
                </div>
            </div>

        </div>
        <!-- /Login-->
    </div>
</div>
<!-- END: Content-->
@endsection
