@extends('back.layouts.login_screen')

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
                        <img height="100" src="{{ asset('media/images/logo-mrav.svg') }}" alt="Skladišna" />
                        <h1 class="h3 font-w700 mt-30 mb-10">Registriraj se</h1>
                        <h2 class="h5 font-w400 text-muted mb-0">Iskoristi svoje pogodnosti...</h2>
                    </div>
                    <!-- END Header -->

                    <!-- Sign Up Form -->
                    <!-- jQuery Validation functionality is initialized with .js-validation-signup class in js/pages/op_auth_signup.min.js which was auto compiled from _es6/pages/op_auth_signup.js -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-signup px-30" action="{{ route('register') }}" method="post">
                        @csrf

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                    <label for="name">Korisničko Ime</label>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                    <label for="email">Email Adresa</label>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
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
                                <div class="form-material floating">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    <label for="password-confirm">Potvrda Lozinke</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="terms" name="terms">
                                    <label class="custom-control-label" for="terms">Slažem se s uvjetima korištenja</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-hero btn-primary">
                                <i class="fa fa-plus mr-10"></i> Registriraj
                            </button>
                            <div class="mt-30">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
                                    <i class="fa fa-book text-muted mr-5"></i> Pročitaj uvjete korištenja
                                </a>
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{ route('login') }}">
                                    <i class="fa fa-user text-muted mr-5"></i> Već Sam Registriran!
                                </a>
                            </div>
                        </div>
                        <input type="hidden" name="recaptcha" id="recaptcha">
                    </form>
                    <!-- END Sign Up Form -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('front.layouts.partials.recaptcha-js')
@endpush
