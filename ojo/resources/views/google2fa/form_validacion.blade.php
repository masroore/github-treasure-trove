@extends('layouts/MasterLogin')
@section('content')
               <div>
                    @if (session()->has('message'))
                          <div class="alert alert-warning my-3">
                              {{ session('message') }}
                          </div>
                      @endif
            <!--layout-->
                    <p>Ingresar el codigo de validación 2FA que aparece en su aplicación Google Autenticator.</p>
                    <form method="POST" action="{{ route('validacion') }}">
                     @csrf

                    <div class="form-group">
                      <input  id="secret"  type="number"  min="6" class="form-control form-control-lg h1 text-center text-dark"  autocomplete="off" name="secret"  required autofocus>
                    </div>

                   <div class="text-center">
                    <button class="btn btn-outline-primary btn-lg" type="submit">  Enviar código </button>
                    </div>
                </form>
            <!--layout-->
@endsection