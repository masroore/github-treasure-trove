@extends('layouts.auth')

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

            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2">
                    <h2 class="card-title fw-bold mb-1 text-white">Recuperar Clave</h2>
                    <form class="auth-login-form mt-2" action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-1">
                            <label class="form-label text-white" for="username">Correo Electronico</label>
                            <input
                                class="form-control @error('email') is-invalid @enderror border border-warning rounded-0"
                                id="username" type="email" required name="email" placeholder="john example"
                                aria-describedby="username" autofocus="" tabindex="1"
                                value="{{ $email ?? old('email') }}" />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label for="password" class="col-form-label text-md-right text-white">{{ __('Clave') }}</label>
                
                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror border border-warning rounded-0"
                                    name="password" required autocomplete="new-password">
                
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                
                        <div class="mb-1">
                            <label for="password-confirm"
                                class="col-form-label text-md-right text-white">{{ __('Confirmar Clave') }}</label>
                
                            <div class="">
                                <input id="password-confirm" type="password" class="form-control border border-warning rounded-0" name="password_confirmation" required
                                    autocomplete="new-password">
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 rounded-0 mt-2" type="submit"
                            tabindex="4">RECUPERAR</button>

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

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

<div class="card-body">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm"
                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div> --}}
