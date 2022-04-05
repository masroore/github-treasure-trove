@extends('layouts.auth')

@section('title')
{{ __('auth.register.create') }}
@endsection

@section('css')
@if(setting()->get('recaptcha_enabled') == "true")
{!! htmlScriptTagJsApi() !!}
@endif
@endsection

@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
        <div class="login-brand">
          <a href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo" class="logo-light" height="80px;">
          </a>
        </div>
        @if(setting()->get('app_mode')=='PRIVATE')
        <div class="card card-danger">
          <div class="card-header">
            <h4 class="text-danger">{{ __('auth.register.closed') }}</h4>
          </div>
        </div>
        @elseif(setting()->get('app_mode')=='PUBLIC')
        @include('partials.errors')
        <div class="card card-primary">
          <div class="card-header">
            <h4>{{ __('auth.register.create') }}</h4>
          </div>

          <div class="card-body">
            @livewire('auth.register')
          </div>
        </div>
        @endif
        <div class="mt-5 text-muted text-center">
          {!! Lang::get('auth.register.registered', ['login' => '/login']) !!}
        </div>
        @include('layouts.partials.footer')
      </div>
    </div>
  </div>
</section>
@endsection