@extends('layouts.auth')

@section('title')
Unlock {{ $vault->name }}
@endsection

@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="login-brand">
          <img src="{{ asset('assets/img/'.setting()->get('app_logo')) }}" alt="logo" class="logo-light" height="80px;">
        </div>
        {!! laraflash()->render() !!}
        <div class="card card-primary">
          <div class="card-header">
            <h4>Unlock <b><u>{{ $vault->name }}</u></b> Vault for this Session!</h4>
          </div>

          <div class="card-body">
            <p class="text-muted">This will unlock the Vault for the duration of your session. The Vault will be auto-locked when you logout.</p>
            <form method="POST" action="{{ route('vaults.select.authenticate', $vault) }}">
              @csrf
              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Vault Password') }}</label>

                <div class="col-md-6">
                  <input id="password" data-toggle="password" type="password" class="form-control" name="password" required>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Unlock Vault') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="mt-5 text-muted text-center">
          Go Back to <a href="{{ route('vaults') }}">My Vaults</a>
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