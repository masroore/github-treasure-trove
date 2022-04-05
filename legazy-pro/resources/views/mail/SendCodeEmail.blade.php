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
                    <h2 class="card-title fw-bold mb-1 text-white">Usuario {{$user}}</h2>
                    <h4>Detalles Orden</h4>

                    <p>Este es su codigo de para el cambio de correo</p>
                    <p>Codigo: {{$code}}</p>
                    
                </div>
            </div>

        </div>
        <!-- /Login-->
    </div>
</div>
<!-- END: Content-->
@endsection
