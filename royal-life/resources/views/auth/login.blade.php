@extends('layouts.auth')

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
    <div class="col-sm-6 col-lg-9 d-none d-sm-flex d-md-flex d-lg-flex align-items-center royal_bg">
        <div class="">
            <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}" alt="">
        </div>
    </div>
    <!-- Login-->
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center p-2">
        <div class="row">
            <h2 class="fw-bold text-white col-12">Iniciar Sesión</h2>
            <form class="mt-2" id="validate" action="{{ route('login') }}" method="POST">
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
                <div class="mb-1 col-12">
                    <label class="form-label text-white" for="username"><b>Usuario</b></label>
                    <input class="form-control border border-primary rounded" type="text" name="username"
                        placeholder="john example" autofocus required tabindex="1" />
                </div>
                <div class="mb-1 col-12">
                    <div class="d-flex justify-content-between">
                        <label class="form-label text-white" for="password"><b>Contraseña</b></label><a
                            href="{{ route('password.request') }}"><small>Olvide
                                mi contraseña</small></a>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input class="form-control border border-primary rounded-left" type="password" name="password"
                            placeholder="························" required tabindex="2" /><span
                            class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                </div>
                <div class="mb-1 col-12">
                    <div class="form-check">
                        <input class="form-check-input border-primary rounded" type="checkbox" name="remember"
                            tabindex="3" {{ old('remember') ? 'checked' : '' }} />
                        <label class="form-check-label text-white" for="remember"><b>Recordar datos</b></label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-outline-primary w-100 rounded mt-1" type="submit"
                        tabindex="4">INGRESAR</button>
                </div>
            </form>
            <p class="text-center mt-2 text-white">¿Aun no tienes una cuenta?&nbsp;<a
                    href="{{ route('register') }}">&nbsp;<b><u>Registrate</u></b></a></p>
        </div>
    </div>
</div>
@endsection

@push('custom_js')
<script>
    // eye
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
