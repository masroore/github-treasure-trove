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
                    <h2 class="card-title fw-bold mb-1 text-white">Iniciar Sesión</h2>
                    <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-1">
                            <label class="form-label text-white" for="username">Usuario</label>
                            <input class="form-control border border-warning rounded-0" id="username" type="text" required name="username"
                                placeholder="john example" aria-describedby="username" autofocus="" tabindex="1" />
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label text-white" for="password">Contraseña</label><a
                                    href="{{ route('password.request') }}"><small>Olvide mi contraseña</small></a>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge border border-warning rounded-0" required id="password" type="password"
                                    name="password" placeholder="························" aria-describedby="password"
                                    tabindex="2" /><span class="input-group-text cursor-pointer"><i
                                        data-feather="eye"></i></span>
                            </div>
                        </div>
    
                        <div class="mb-1">
                            <div class="form-check">
                                <input class="form-check-input border-warning rounded-0" id="remember-me" type="checkbox" tabindex="3" />
                                <label class="form-check-label text-white" for="remember-me">Recordar datos</label>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 rounded-0 mt-2" type="submit" tabindex="4">INGRESAR</button>
    
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

@push('page_js')
<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })

</script>
@endpush
