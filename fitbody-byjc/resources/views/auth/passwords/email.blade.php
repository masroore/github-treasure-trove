@extends('back.layouts.login_screen')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
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
                    <div class="px-30 py-10">
                        <img height="100" src="{{ asset('media/images/logo-mrav.svg') }}" alt="Agrocon" />
                        <h1 class="h3 font-w700 mt-30 mb-10">Resetiraj Lozinku!</h1>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class=" row px-30">
                                <div class="col-12">
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form  class="px-30" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material floating">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                        <label for="email" >Email Adresa</label>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <button type="submit" class="btn btn-primary">
                                    Pošalji Link za Obnovu Lozinke
                                </button>
                                <div class="mt-30">
                                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{ route('login') }}">
                                        <i class="fa fa-user text-muted mr-5"></i> Znam Svoju Lozinku
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
