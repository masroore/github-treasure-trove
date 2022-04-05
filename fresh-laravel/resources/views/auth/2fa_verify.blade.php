@extends('layouts.app')
@section('content')

    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{ __('Two Factor Authentication') }}</h4>
                        </div>

                        <div class="card-body">
                            {{ __('Enter the pin from Google Authenticator app:') }}<br /><br />

                            <form class="form-horizontal" action="{{ route('2faVerify') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('one_time_password-code') ? ' has-error' : '' }}">
                                    <label for="one_time_password"
                                        class="control-label">{{ __('One Time Password') }}</label>
                                    <input id="one_time_password" name="one_time_password" class="form-control col-md-6"
                                        type="text" required />
                                </div>
                                <button class="btn btn-primary" type="submit">{{ __('Authenticate') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
