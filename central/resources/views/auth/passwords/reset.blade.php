@extends('layouts.app')

@section('title', trans('passwords.page_title'))

@section('content')
<section class="pt-5 pb-5 background-dark background-theme body-min-height">
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="card background-black-dark border-panel">
                    <div class="card-body py-5 px-sm-5">
                        <div class="text-center">
                            <h3 class="text-primary">{{ trans('passwords.page_title') }}</h3>
                        </div>
                        <hr>
                        <form method="post" class="form-validate" action="{{ route('password.update') }}">
                        @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-light">{{ trans('passwords.email') }}</label>
                                <div class="col-md-9">
                                    <input class="form-control input-dark-bg text-light @error('email') is-invalid @enderror" type="text" name="email" value="{{ $email ?? old('email') }}" autofocus>
                                    @error('email')
                                    <div class="is-invalid">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-3 col-form-label text-light">{{ trans('passwords.password') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group show-hide-password">
                                        <input class="form-control text-light input-dark-bg @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('passwords.password') }}" type="password" >
                                        <span class="input-group-text input-dark-bg text-light"><i class="icon-eye-off" aria-hidden="true" style="cursor: pointer;"></i></span>
                                    </div>
                                    @error('password')
                                    <div class="is-invalid">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-3 col-form-label text-light">{{ trans('passwords.password_confirmation') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group show-hide-password">
                                        <input class="form-control text-light input-dark-bg" name="password_confirmation" placeholder="{{ trans('passwords.password_confirmation') }}" type="password" >
                                        <span class="input-group-text input-dark-bg text-light"><i class="icon-eye-off" aria-hidden="true" style="cursor: pointer;"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('buttons.reset_pwd') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf




                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
