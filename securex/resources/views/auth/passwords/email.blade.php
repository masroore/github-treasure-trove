@extends('layouts.auth')

@section('title')
{{ __('auth.login.forgot') }}
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
            <h4>{{ __('auth.forgot.head') }}</h4>
          </div>

          <div class="card-body">
            <p class="text-muted">{{ __('auth.forgot.sub') }}</p>
            @if (session('status'))
            <div class="custom-error">
              <div class="cerror success pull-up">
                <strong>Success!</strong> {{ session('status') }}
              </div>
            </div>
            @endif
            <form id="forgot-pass" method="POST" action="{{ route('password.email') }}">
              @csrf

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

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary disable">
                    {{ __('auth.forgot.btn') }}
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
    $(this).text("Requesting Link...");
    $("#forgot-pass").submit();
  });
</script>
@endsection
