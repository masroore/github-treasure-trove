@extends('layouts.auth')

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/auth/css/email.css')}}">
@endpush

@section('content')
<div class="row d-flex justify-content-center">
    <div class="text-center col-12">
        <img src="{{asset('assets/img/royal_green/logos/logo.svg')}}" class="img-fluid" width="650px" alt="bg">
    </div>
    <div class="col-10 col-ms-5 col-md-6 col-lg-4 row">
        <div class="card" style="background: #11262C;">
            <div class="card-header d-flex justify-content-center">
                <h3 class="card-title text-input-holder text-white"><b>Cambiar Contraseña</b></h3>
            </div>
            <div class="card-body col-12">
                <form method="POST" id="validate" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
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
                        <div class="col-12 mb-1">
                            <input type="email" class="form-control border border-primary rounded" name="email"
                                value="{{ $email ?? old('email') }}" required placeholder="Correo electronico">
                        </div>
                        <div class="mb-1 col-12">
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control border border-primary rounded-left" type="password"
                                    name="password" placeholder="Nueva contraseña" required tabindex="2" /><span
                                    class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <div class="mb-1 col-12">
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control border border-primary rounded-left" type="password"
                                    name="password_confirmation" placeholder="Confirmar contraseña" required
                                    tabindex="2" /><span class="input-group-text cursor-pointer"><i
                                        data-feather="eye"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary rounded mt-1">
                                <b>Cambiar Contraseña</b>
                            </button>
                            <a href="{{route('login')}}" class="btn btn-danger rounded mt-1">
                                <b>Volver al inicio</b>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
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
