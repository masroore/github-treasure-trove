@extends('layouts.auth')

@section('content')
@push('custom_css')
<style>

</style>
@endpush
<!-- BEGIN: Content-->
<div class="auth-wrapper auth-v2">
    <div class="auth-inner row m-0">

    
    <!-- Left bg-->
    <div class="d-none d-lg-flex col-lg-8 align-items-center legazy_bg">
        <div class="align-items-center justify-content-center">
            <div class= "row justify-content-center">
                <div class="col-auto">
                     <img src="{{ asset('assets/img/legazy_pro/logo.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Login-->
    <div class="d-flex col-lg-4 align-items-center auth-bg p-lg-4">
        
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2">
                <h2 class="card-title fw-bold mb-1 text-white">Recuperar Clave</h2>
                <form class="auth-login-form mt-2" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-1">
                        <label class="form-label text-white" for="username">Correo Electronico</label>
                        <input class="form-control border border-warning rounded-0" id="username" type="email" required name="email"
                            placeholder="john example" aria-describedby="username" autofocus="" tabindex="1" />
                    </div>

                    <button class="btn btn-primary w-100 rounded-0 mt-2" type="submit" tabindex="4">RECUPERAR</button>

                    <a class="btn btn-primary w-100 rounded-0 mt-2" href="{{ route('login') }}">LOGIN</a>

                </form>
                {{-- <p class="text-center mt-2"><span>¿Nuevo en la plataforma?</span><a
                        href="{{ route('register') }}"><span>&nbsp;<b>Crea una cuenta</b></span></a></p> --}}
            </div>
        </div>

    </div>
    <!-- /Login-->
</div>
</div>
<!-- END: Content-->
@endsection
