@extends('layouts.auth')

@section('title')
{{ __('auth.reset.password') }}
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
                        <h4>{{ __('auth.reset.password') }}</h4>
                    </div>

                    <div class="card-body">
                        @include('partials.errors')
                        <p class="text-muted">{{ __('auth.reset.sub') }}</p>
                        <form id="reset-pass" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('profile.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('profile.email_placeholder') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.reset.master_password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('auth.register.password_placeholder') }}" required autofocus>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('auth.reset.master_password_confirm') }}</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="{{ __('auth.register.password_confirm') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary disable">
                                        {{ __('auth.reset.password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-5 text-muted text-center">
                    {!! Lang::get('auth.forgot.remember', ['login' => '/login']) !!}
                </div>
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $('.disable').click(function() {
        $(this).prop('disabled', true);
        $(this).text("Resetting Password...");
        $("#reset-pass").submit();
    });
</script>
@endsection