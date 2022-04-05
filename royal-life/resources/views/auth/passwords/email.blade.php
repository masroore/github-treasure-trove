@extends('layouts.auth')

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/auth/css/email.css')}}">
@endpush

@section('content')
{{-- <div class='under'> --}}
<div class="row d-flex justify-content-center">
    <div class="text-center col-12">
        <img src="{{asset('assets/img/royal_green/logos/logo.svg')}}" class="img-fluid" width="650px" alt="bg">
    </div>
    <div class="col-10 col-ms-6 col-md-6 col-lg-4 row">
        <div class="card" style="background: #11262C;">
            <div class="card-header d-flex justify-content-center">
                <h3 class="card-title text-input-holder text-white"><b>Restablecer Contraseña</b></h3>
            </div>
            <div class="card-body col-12">
                <h5 class="text-white mb-2">
                    Te vamos a enviar un código a la dirección de correo que ingreses para que recuperes
                    tu contraseña.
                </h5>
                @if (session('status'))
                <div class="alert alert-info" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" id="validate" action="{{ route('password.email') }}">
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
                        <div class="col-12">
                            <input type="email" class="form-control border border-primary rounded" name="email"
                                value="{{ old('email') }}" required placeholder="Ingresa tu email">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary rounded mt-1">
                                <b>Enviar Código</b>
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
{{-- <div class='wave'></div>
    <div class='wave wave2'></div>
    <div class='wave wave3'></div>
</div> --}}
@endsection

@push('custom_js')
<script>
    $("#validate").validate();
</script>
@endpush
