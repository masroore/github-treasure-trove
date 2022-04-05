@extends('layouts.auth')

@section('content')
@push('custom_css')
<style>
    .bg-fucsia {
        background: transparent linear-gradient(180deg, #007DFF 0%, linear-gradient(90deg, rgba(17,38,44,1) 0%, rgba(54,99,112,1) 68%) 100%) 0% 0% no-repeat padding-box;
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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-8 col-12">
            {{-- header --}}
            <div class="col-12 text-center mb-2">
                <img src="{{asset('assets/img/sistema/logo-viral_media-blanco.png')}}" alt="logo" height="40" class="mb-3">
                <h5 class="text-white">Bienvenido a <br> ViralMediaPanel</h5>
            </div>
            {{-- cuerpo login --}}
            <div class="card mb-1 card-margin">
                <div class="card-header">
                    <h1 class="text-dark text-center col-12"><b>Terminos y Politica de la pagina</b></h1>
                </div>

                <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                        {!! $config->term !!}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <a href="{{route('register')}}" class="btn bg-fucsia text-white btn-block btn-login">
                                    {{ __('Regresar al Registro') }}
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
