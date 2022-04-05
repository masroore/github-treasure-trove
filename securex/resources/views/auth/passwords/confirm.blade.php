@extends('layouts.auth')

@section('title')
{{ __('auth.confirm.title') }}
@endsection

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-brand">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo" class="logo-light" height="80px;">
                    </a>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{ __('auth.confirm.head') }}</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">{{ __('auth.confirm.sub') }}</p>
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.register.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" data-toggle="password" type="password" placeholder="{{ __('auth.login.password_placeholder') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('auth.confirm.btn') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('auth.login.forgot') }}?
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-5 text-muted text-center">
                    <a href="{{ URL::previous() }}">{{ __('auth.confirm.return') }}</a>
                </div>
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/bootstrap-show-password.min.js') }}"></script>
@endsection