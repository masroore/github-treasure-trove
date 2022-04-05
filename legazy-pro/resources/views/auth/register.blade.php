@extends('layouts.auth')

@php
$referred = null;
@endphp

@if ( request()->referred_id != null )
@php
$referred = DB::table('users')
->select('fullname')
->where('id', '=', request()->referred_id)
->first();
@endphp
@endif

<style>
    html {
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
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <img src="{{ asset('assets/img/legazy_pro/logo.svg') }}" alt="">
                    </div>
                </div>

            </div>
        </div>
        <!-- Login-->
        <div class="d-flex col-lg-4 align-items-center auth-bg p-lg-4">

            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2">
                <h2 class="card-title fw-bold mb-2 text-white">Crear Cuenta</h2>
                @if (!empty($referred))
                <h5>Referido por: {{$referred->fullname}}</h5>
                @endif
            <form class="auth-login-form mt-2" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label class="form-label text-white mb-1" for="fullname"><b>Nombre y Apellido</b></label>
                    <input class="form-control border border-warning rounded-0" id="fullname" type="text" required
                        name="fullname" placeholder="john example" />
                </div>
                <div class="mb-2">
                    <label class="form-label text-white mb-1" for="username"><b>Nombre de usuario</b></label>
                    <input class="form-control border border-warning rounded-0" id="username" type="text" required
                        name="username" placeholder="john example" />
                </div>
                <div class="mb-2">
                    <label class="form-label text-white mb-1" for="email"><b>Correo Electronico</b></label>
                    <input class="form-control border border-warning rounded-0" id="email" type="email" required
                        name="email" placeholder="john@example.com" />
                </div>
                <div class="mb-2">
                    {{-- <label class="form-label text-white mb-1" for="referred_id"><b>Auspiciador</b></label> --}}
                    @if (!empty($referred))
                    <input class="form-control border border-warning rounded-0" id="referred_id" type="hidden"
                        name="referred_id" placeholder="" aria-describedby="referred_id" autofocus="" readonly
                        value="{{request()->referred_id}}" />
                    @else
                    <input class="form-control border border-warning rounded-0" id="referred_id" type="hidden"
                        name="referred_id" placeholder="Sin Auspiciador" aria-describedby="referred_id" autofocus=""
                        readonly value="1" />
                    @endif
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <label class="form-label text-white mb-1" for="password"><b>Contraseña</b></label>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input class="form-control form-control-merge border border-warning rounded-0" id="password"
                            type="password" required name="password" placeholder="························"
                            aria-describedby="password" tabindex="2" />
                        <span class="input-group-text cursor-pointer rounded-0"><i data-feather="eye"></i></span>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <label class="form-label text-white mb-1" for="password"><b>Confirmar Contraseña</b></label>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input class="form-control form-control-merge border border-warning rounded-0" type="password"
                            required name="password_confirmation" placeholder="························"
                            aria-describedby="password" tabindex="2" />
                        {{-- <span class="input-group-text cursor-pointer rounded-0"><i data-feather="eye"></i></span> --}}
                    </div>
                </div>

                <button class="btn btn-primary w-100 rounded-0 mt-2" type="submit" tabindex="4">Crear cuenta</button>
            </form>
            <p class="text-center mt-2"><span>¿Ya tienes una cuenta?</span><a
                    href="{{ route('login') }}"><span>&nbsp;<b>Iniciar sesión</b></span></a></p>
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
