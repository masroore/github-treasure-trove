@extends('back.layouts.login_screen')

@push('css_before')
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
                    <div class="px-30 mb-50">
                        <img height="100" src="{{ asset('media/images/logo-mrav.svg') }}" alt="Agrocon" />
                        <h1 class="h3 font-w700 mt-10">Upiši Novu Lozinku!</h1>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email Adresa</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Lozinka</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Potvrda Lozinke</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
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
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    {{--<script src="{{ asset('js/pages/be_forms_plugins.min.js') }}"></script>--}}
    <!-- Page JS Helpers (Table Tools helper) -->
    <script>
        jQuery(function () {
            Codebase.helpers('select2');
        });
    </script>
@endpush
