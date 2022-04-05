@extends('layouts.app')

@section('title', trans('login.title'))

@section('content')
    <section class="pt-5 pb-5 background-dark background-theme body-min-height">
        <div class="container-fluid d-flex flex-column">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-4 col-xl-3 mx-auto">
                    <div class="card background-black-dark border-panel">
                        <div class="card-body py-5 px-sm-5">
                            <div class="mb-5 text-center">
                                <h6 class="h3 mb-1 text-primary">{{ config('app.name', 'ADAM Bit') }}</h6>
                                <p class="text-muted mb-0">{{ trans('login.page_title') }}</p>
                            </div><span class="clearfix"></span>
                            <hr>
                            <form method="post" class="form-validate" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="login" class="text-light">{{ trans('login.login') }}</label>
                                    <div class="input-group text-light">
                                        <input type="text" class="form-control input-dark-bg text-light {{ $errors->has('login_id') || $errors->has('email') ? 'is-invalid' : '' }}" name="login" placeholder="{{ trans('login.login') }}" value="{{ old('login_id') ?: old('email') }}" autofocus>
                                        <span class="input-group-text input-dark-bg"><i class="icon-user"></i></span>
                                    </div>
                                    @if ($errors->has('login_id') || $errors->has('email'))
                                        <div class="is-invalid">{{ $errors->first('login_id') ?: $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="text-light">{{ trans('login.password') }}</label>
                                    <div class="input-group show-hide-password text-light">
                                        <input class="form-control input-dark-bg text-light @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('login.password') }}" type="password">
                                        <span class="input-group-text input-dark-bg"><i class="icon-eye-off" aria-hidden="true" style="cursor: pointer;"></i></span>
                                    </div>
                                    @error('password')
                                        <div class="is-invalid">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ trans('buttons.login') }}</button>
                                </div>
                            </form>
                            <div class="mt-4 text-center">
                                <div><a href="{{ route('password.request') }}" class="small fw-bold">{{ trans('buttons.forgot') }}</a></div>
                                <div><a href="{{ route('register') }}" class="small fw-bold">{{ trans('buttons.register_now') }}</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $('#top_login').addClass('text-danger');
        });
    </script>
@endsection