@extends('layouts.app')


@section('content')

    <section class="register" style="background-image: url({{asset('/img/miscellaneous/bg_login.jpg')}})">


        <div class="row justify-content-center px-3 px-md-0">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card rgba-white-strong ">
                    <div class="card-body p-5">


                        <h1 class="h1-responsive text-center text-ce-soir">Iniciar Sesión</h1>
                        <h3 class="h3-responsive text-grey-suit font-weight-bold text-center mt-3"> Continúa con tu
                            proceso</h3>

                        <form class="login-form" action="{{route('login')}}" method="POST" autocomplete="off">

                            @csrf
                            <div class="md-form">
                                <label for="exampleInputEmail1" class="control-label text-ce-soir font-weight-bold">Correo
                                    electrónico</label>
                                <input type="text" name="email" class="form-control" placeholder="" autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                @endif
                            </div>
                            <div class="md-form">
                                <label for="exampleInputPassword1"
                                       class="control-label text-ce-soir font-weight-bold">Contraseña</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="" autocomplete="off">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                @endif
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" name="remember_token" class="custom-control-input"
                                       id="customControlValidation1">
                                <label class="custom-control-label" for="customControlValidation1">Recordarme</label>
                            </div>

                            <div class="my-3">
                                @include('_partials/error_handling',["variable"=>'error',"color"=>"danger"])
                            </div>


                            <button type="submit"
                                    class="btn btn-ce-soir btn-block btn-lg white-text">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </button>

                            <h5 class=" text-center mt-3">
                                <a href="{{route('web.getRegisterMom')}}" class="text-ce-soir ">
                                    ¿Aún no tienes una cuenta?
                                </a>

                            </h5>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>


@endsection
