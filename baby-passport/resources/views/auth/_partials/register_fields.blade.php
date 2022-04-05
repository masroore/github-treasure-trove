<form id="registerForm" action="{{route('register')}}" method="POST" autocomplete="off">


    @include("_partials/error_handling",["variable"=>"success","color"=>"success"])
    @include("_partials/error_handling",["variable"=>"error","color"=>"danger"])


    <input type="hidden" name="type" value="{{$userType}}">
    @csrf


    <h1 class="text-center mt-2">{{$userTypeDescription}}</h1>

    @if ($userType=='pacient')
        <h5 class="text-ce-soir font-weight-bold text-center"> Regístrate para iniciar tu proceso.</h5>

    @else
        <h5 class="text-ce-soir font-weight-bold text-center"> Regístrate para comenzar a recibir pacientes.</h5>
    @endif


    <div class="md-form mt-4">
        <label for="" class="label control-label text-ce-soir font-weight-bold">Nombre Completo</label>
        <input type="text"
               class="form-control btn-full-rounded {{$errors->has('name') ? ' is-invalid' : '' }}"
               name="name"
               required
               value="{{ old('name') }}"/>
        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
        @endif

    </div>

    <div class="md-form my-4">
        <label for="" class="label control-label text-ce-soir font-weight-bold">Teléfono/Whatsapp</label>
        <input type="text"
               class="form-control btn-full-rounded {{$errors->has('phone') ? ' is-invalid' : '' }}"
               name="phone"
               required
               value="{{ old('phone') }}"/>
        @if ($errors->has('phone'))
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
        @endif

    </div>

    <div class="md-form mb-4">
        <label for="" class="control-label text-ce-soir font-weight-bold">Correo electrónico</label>
        <input
                type="email"
                class="form-control btn-full-rounded {{$errors->has('email') ? ' is-invalid' : '' }}"
                name="email"
                required
                value="{{ old('email') }}"/>
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
        @endif
    </div>


    <div class="md-form mb-4">
        <label for="" class="control-label text-ce-soir font-weight-bold">Contraseña</label>
        <input
                type="password"
                required
                class="form-control btn-full-rounded {{$errors->has('password') ? ' is-invalid' : '' }}"
                name="password"
        />
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="md-form">
        <label for="" class="control-label text-ce-soir font-weight-bold">Confirmar contraseña</label>
        <input
                type="password"
                required
                class="form-control btn-full-rounded {{$errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                name="password_confirmation"/>

        @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>

    <div class="row mt-3 text-center">
        <div class="col-12">
            <button type="submit"

                    class="btn btn-ce-soir text-light btn-block p-3 shadow btn-full-rounded">
                <i class="fas fa-user-plus"></i> Registrarme
            </button>

            <h5 class="mt-3">
                <a href="{{route('login')}}" class="text-ce-soir ">
                    ¿Ya tienes una cuenta?
                </a>

            </h5>

        </div>
    </div>
</form>
