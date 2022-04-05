@extends('layouts.auth')

@section('title')
{{ __('auth.login.btn') }}
@endsection

@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <a href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo" class="logo-light" height="80px;">
          </a>
        </div>
        @include('partials.account-alerts')
        @if(session()->has('danger'))
        <div class="alert alert-danger" role="alert">
            <strong>Sorry!</strong> {{ session('danger') }}
        </div>
        @endif
        <div class="card card-primary">
          <div class="card-header">
            <h4>{{ __('auth.login.btn') }}</h4>
          </div>

          <div class="card-body">
            <!-- Login Form Livewired -->
            @livewire('auth.login')

            <!-- Check if public registrations are open -->
            @if(setting()->get('app_mode')=='PUBLIC')
              @if(setting()->get('social_logins_enabled') == 'true')
              <hr class="hr-text" data-content="OR">
              <div class="text-center mt-4 mb-3">
                <div class="text-job text-muted un">Login With Social</div>
              </div>
              <div class="row sm-gutters">
                <div class="col-md-12">
                  @if(setting()->get('github_enabled') == 'true')
                  <a href="{{ route('login.github') }}" class="btn btn-block btn-social btn-github">
                    <span class="fab fa-github"></span> Sign in with GitHub
                  </a>
                  @endif
                  @if(setting()->get('facebook_enabled') == 'true')
                  <a class="btn btn-block btn-social btn-facebook">
                    <span class="fab fa-facebook"></span> Sign in with Facebook
                  </a>
                  @endif
                  @if(setting()->get('twitter_enabled') == 'true')
                  <a class="btn btn-block btn-social btn-twitter">
                    <span class="fab fa-twitter"></span> Sign in with Twitter
                  </a>
                  @endif
                </div>
              </div>
              @endif
            @endif
          </div>
        </div>
        @if(setting()->get('app_mode')=='PUBLIC')
        <div class="mt-5 text-muted text-center">
          {!! Lang::get('auth.login.new', ['register' => '/register']) !!}
        </div>
        @endif

        @include('layouts.partials.footer')
      </div>
    </div>
  </div>
</section>
@endsection