@extends('layouts.auth')

@section('content')
@push('custom_css')
<style>
    .bg-fucsia {
        background: transparent linear-gradient(180deg, #007DFF 0%, linear-gradient(90deg, rgba(172,118,19,1) 0%, rgba(214,168,62,1) 68%) 100%) 0% 0% no-repeat padding-box;
    }

    .text-rosado {
        color: #007DFF;
    }

    .btn-login {
        padding: 0.6rem 2rem;
        border-radius: 1.429rem;
    }

    .text-input-holder {
        font-weight: 800;
        color: #000000;
    }

    .card{
        border-radius: 1.5rem;
    }
</style>
@endpush
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-8 col-12">
            {{-- header --}}
            <div class="col-12 text-center">
                <img src="{{asset('assets/img/HDLRS-side.png')}}" alt="logo" height="140" width="190">
                <h5 class="text-white">Bienvenido a HDLRS</h5>
            </div>
            {{-- cuerpo login --}}
            <div class="card mb-1 card-margin">
                <div class="card-header">
                    <h5 class="card-title text-center col-12 text-input-holder">{{ __('Iniciar Sesión') }}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
 
                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="username" type="username"
                                    class="form-control text-input-holder @error('username') is-invalid @enderror"
                                    name="username" value="{{ old('username') }}" required autocomplete="username" autofocus
                                    placeholder="Ingresa tu username">

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- PARA ENTRAR CON EL EMAIL --}}
                        {{-- <div class="form-group row">

                            <div class="col-md-12">
                                <input id="email" type="email"
                                    class="form-control text-input-holder @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Ingresa tu email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password"
                                    class="form-control text-input-holder @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password"
                                    placeholder="Ingresa tu contraseña">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                @if (Route::has('password.request'))
                                <a class="text-rosado" href="{{ route('password.request') }}">
                                    {{ __('Olvidé mi contraseña ->') }}
                                </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn bg-fucsia text-white btn-block btn-login">
                                    {{ __('Ingresar') }}
                                </button>
                            </div>
                        </div>

                        <fieldset class="checkbox mt-1">
                            <div class="vs-checkbox-con vs-checkbox-danger justify-content-center">
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span class="">Recordar</span>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <p class="text-center">
                    <small >
                        <span>¿Aun no tienes una cuenta?</span>
                        <br>
                        <a class="text-rosado" href="{{ route('register') }}">
                            {{ __('Registrate') }}
                        </a>
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
