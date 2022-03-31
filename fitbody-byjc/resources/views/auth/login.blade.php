@extends('back.layouts.login_screen')

@push('css_before')
    {{--<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">--}}
@endpush

@section('content')

    <div class="bg-image" style="background-image: url({{ asset('media/temp/slider/1.jpg') }});">
        <div class="row mx-0 bg-black-op">
            <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                <div class="p-30 invisible" data-toggle="appear">
                    <p class="font-size-h3 font-w600 text-white">
                        {{ config('app.name') }}
                    </p>
                    <p class="font-italic text-white-op">
                        &copy; <span class="js-year-copy">2020</span>. Sva prava pridržana. {{ config('app.name') }} d.o.o.
                    </p>
                </div>
            </div>
            <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible" data-toggle="appear" data-class="animated fadeInRight">
                <div class="content content-full">
                    <!-- Header -->
                    <div class="px-30 py-10">
                        <img height="70" src="{{ asset('media/images/logo-mrav.svg') }}" alt="{{ config('app.name') }}" />
                        <h1 class="h3 font-w700 mt-30 mb-10">Logiraj se</h1>
                        <h2 class="h5 font-w400 text-muted mb-0">Uđi u svoj korisnički portal...</h2>
                    </div>
                    <!-- END Header -->

                    <!-- Sign In Form -->
                    <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-signin px-30" action="{{ route('login') }}" method="post">
                        @csrf

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                    <label for="email">Korisničko ime</label>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    <label for="password">Lozinka</label>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Zapamti me!</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-hero btn-primary">
                                <i class="si si-login mr-10"></i>Login
                            </button>
                            <div class="mt-30">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{ route('register') }}">
                                    <i class="fa fa-plus mr-5"></i> Registriraj se
                                </a>
                                @if (Route::has('password.request'))
                                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{ route('password.request') }}">
                                        <i class="fa fa-warning mr-5"></i> Zaboravio sam lozinku
                                    </a>
                                @endif
                            </div>
                        </div>


                        {{--<div class="block block-bordered mt-50">
                            <div class="block-content block-content-full">
                                <div class="row justify-content-center h4 mb-30 font-weight-light">Prijavi se kao</div>
                                <div class="row justify-content-center">
                                    <a class="btn btn-secondary mr-5" href="{{ route('login.as', ['role' => 'admin']) }}">Administrator</a>
                                    --}}{{--<a class="btn btn-secondary mr-5" href="{{ route('login.as', ['role' => 'editor']) }}">Editor</a>--}}{{--
                                    --}}{{--<a class="btn btn-secondary" href="{{ route('login.as', ['role' => 'customer']) }}">User</a>--}}{{--
                                </div>
                            </div>
                        </div>--}}


                    </form>
                    <!-- END Sign In Form -->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{--<script src="{{ asset('js/pages/be_forms_plugins.min.js') }}"></script>--}}
@endpush
