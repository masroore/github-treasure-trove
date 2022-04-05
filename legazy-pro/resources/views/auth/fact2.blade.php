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
                    <h2 class="card-title fw-bold mb-1 text-white">Verificar 2Fact</h2>
                    <form class="auth-login-form mt-2" action="{{ route('2fact.post') }}" method="POST">
                        @csrf
                        @if (!empty($urlQr))
                        <div class="mb-1">
                            <img src="{{$urlQr}}" alt="codigo qr google">
                        </div>
                        @endif
                        <div class="mb-1">
                            <label class="form-label text-white" for="username">Codigo 2Fact</label>
                            <input class="form-control border border-warning rounded-0" id="username" type="text" required name="code"
                                placeholder="000000" aria-describedby="username" autofocus="" tabindex="1" />
                        </div>    
                        <button class="btn btn-primary w-100 rounded-0 mt-2" type="submit" tabindex="4">Verificar</button>
                        <a class="btn btn-primary w-100 rounded-0 mt-2" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="feather icon-log-out"></i> Salir
                        </a>
                    </form>
                     {{-- formulario de salir --}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
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
