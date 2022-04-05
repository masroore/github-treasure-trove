@extends('dashboard.authBase')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container">
      <div class="row justify-content-center" style="margin-right:0;margin-left:0;">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Iniciar Sesión</h1>
                <p class="text-muted">Entra con tu cuenta</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <svg class="c-icon">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                        </svg>
                      </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('Dirección de E-Mail') }}" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="input-group mb-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <svg class="c-icon">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                        </svg>
                      </span>
                    </div>
                    <input class="form-control" type="password" placeholder="{{ __('Contraseña') }}" name="password" required>
                    </div>
                      <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary px-4" type="submit" style = "width:100%">{{ __('Iniciar sesión') }}</button>
                        </div>
                      </div>
                      <br>
                      <div class="col-12 text-center">                                                    
                          <a href="{{ route('password.request') }}" style = "width:100%">{{ __('Restablecer contraseña') }}</a>
                      </div>
                    
                    
                    <p class="mt-0 mb-1 text-center lead">-o-</p>
                    
                    <div id="tabla_filter" class="rrssButtonGroup">
                      <!--div class="facebookButton">
                      <a href="{{url('login/facebook')}}" class="btn btn-facebook" style = "width:100%"> <svg class="c-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                      {{ __('Iniciar sesión con Facebook') }}
                        </a>
                      </div><br-->
                      <div class="googleButton">
                        <button class="btn btn-danger px-4" type="submit" style = "width:100%">
                          <svg class="c-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
                          {{ __('Iniciar sesión con Google') }}
                        </button>
                      </div>
                    </div>
                    </form>

              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="logincrd card-body text-center">
                <div>
                  <h2>No tienes cuenta?</h2>
                  <p>Haz click en Registrarse para obtener una :)</p>
                  @if (Route::has('password.request'))
                    <a href="{{ route('register') }}" class="btn btn-primary active mt-3">{{ __('Registrarse') }}</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('javascript')

@endsection