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

@push('custom_css')
<style>
    html {
        overflow-x: hidden;
    }

</style>
@endpush

@section('content')
<div class="row auth-inner">
    <!-- Left bg-->
    <div class="col-sm-5 col-lg-8 d-none d-sm-flex d-md-flex d-lg-flex align-items-center royal_bg">
        <div class="">
            <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}" alt="">
        </div>
    </div>
    <!-- Login-->
    <div class="col-12 col-sm-7 col-lg-4 d-flex align-items-center p-2">
        <div class="row">
            <h2 class="fw-bold text-white col-12">Crear Cuenta</h2>
            @if (!empty($referred))
            <h4 class="mt-1 text-white">Referido por: <b class="text-primary"> {{$referred->fullname}}</b></h4>
            @endif
            <form class="mt-2" id="validate" action="{{ route('register') }}" method="POST">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
                    <div class="mb-2 col-6">
                        <label class="form-label text-white mb-1" for="fullname"><b>Nombre y Apellido</b></label>
                        <input class="form-control border border-primary rounded" type="text" name="fullname"
                            placeholder="john example" required autofocus tabindex="1" />
                    </div>
                    <div class="mb-2 col-6">
                        <label class="form-label text-white mb-1" for="username"><b>Nombre de usuario</b></label>
                        <input class="form-control border border-primary rounded" type="text" name="username"
                            placeholder="john example" required tabindex="2" />
                    </div>
                </div>
                <div class="mb-2 col-12">
                    <label class="form-label text-white mb-1" for="email"><b>Correo Electronico</b></label>
                    <input class="form-control border border-primary rounded" type="email" name="email"
                        placeholder="john@example.com" required tabindex="3" />
                </div>
                <div class="mb-2 col-12 d-none">
                    <label class="form-label text-white mb-1" for="referred_id"><b>Auspiciador</b></label>
                    @if (!empty($referred))
                    <input class="form-control border border-primary rounded" type="text" name="referred_id" readonly
                        value="{{request()->referred_id}}" />
                    @else
                    <input class="form-control border border-primary rounded" type="text" name="referred_id"
                        placeholder="Sin Auspiciador" readonly value="1" />
                    @endif
                </div>
                <div class="row">
                    <div class="mb-2 col-6">
                        <label class="form-label text-white mb-1" for="password"><b>Contraseña</b></label>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input class="form-control border border-primary rounded-left" type="password"
                                name="password" placeholder="························" required tabindex="4" /><span
                                class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                    <div class="mb-2 col-6">
                        <label class="form-label text-white mb-1" for="password_confirmation"><b>Confirmar
                                C.</b></label>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input class="form-control border border-primary rounded-left" type="password"
                                name="password_confirmation" placeholder="························" required
                                tabindex="5" /><span class="input-group-text cursor-pointer"><i
                                    data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="mb-1 col-12">
                    <div class="form-check">
                        <input class="form-check-input border-primary rounded" type="checkbox" name="term" required
                            tabindex="6" />
                        <label class="form-check-label" for="term"><b><a href="#" class="text-white">¿Aceptas los
                                    Terminos y
                                    Condiciones?</a></b></label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-outline-primary w-100 rounded mt-1" type="submit" tabindex="7">Crear
                        cuenta</button>
                </div>
            </form>
            <p class="text-center mt-2 text-white">¿Ya tienes una cuenta?&nbsp;<a
                    href="{{ route('login') }}">&nbsp;<b>Iniciar sesión</b></a></p>
        </div>
    </div>
</div>
@endsection

@push('custom_js')
<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })

    $("#validate").validate();

</script>
@endpush
