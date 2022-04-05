@extends('layouts.auth')

@section('content')
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
                <h2 class="card-title fw-bold mb-1 text-white">Confirmar Clave</h2>
                <form class="auth-login-form mt-2" action="{{ route('password.confirm')}}" method="POST">
                    @csrf
                    <div class="mb-1">
                        <label class="form-label text-white" for="username">Clave</label>
                        <input class="form-control border border-warning rounded-0 @error('password') is-invalid @enderror" id="password" type="email" required name="password"
                            placeholder="clave actual" aria-describedby="password" autofocus="" tabindex="1" />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary w-100 rounded-0 mt-2" type="submit" tabindex="4">Confirmar Clave</button>

                    <a class="btn btn-primary w-100 rounded-0 mt-2" href="{{ route('password.request') }}">Recuperar clave</a>

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
