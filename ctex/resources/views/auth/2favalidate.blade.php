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
                            <form method="post" class="form-validate" action="{{ route('2fa.validate') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="login" class="text-light">{{ trans('login.2fa_code') }}</label>
                                    <div class="input-group text-light">
                                        <input type="text" class="form-control input-dark-bg text-light @error('verification_code') is-invalid @enderror" name="verification_code" placeholder="{{ trans('login.2fa_code') }}" value="{{ old('verification_code') }}" autofocus>
                                    </div>
                                    @error('verification_code')
                                        <div class="is-invalid">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ trans('buttons.authenticate') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection