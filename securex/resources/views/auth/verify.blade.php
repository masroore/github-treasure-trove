@extends('layouts.auth')

@section('title')
Verify your email address
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
        @include('partials.errors')
        <div class="card card-primary">
          <div class="card-header">
            <h4>{{ __('Verify Your Email Address') }}</h4>
          </div>

          <div class="card-body">
            @if (session('resent'))
            <div class="alert alert-success" role="alert">
              {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link. Do not forget to check your spam folder as well.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
              @csrf
              <button type="submit" class="btn btn-link text-primary p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
          </div>
        </div>
        <div class="mt-5 text-muted text-center">
          Not {{ Auth::user()->first_name }} ? <a href="{{ route('logout') }}">Logout</a>
        </div>
        @include('layouts.partials.footer')
      </div>
    </div>
  </div>
</section>
@endsection