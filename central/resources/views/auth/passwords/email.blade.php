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
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" id="success_div">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->has('failed'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $errors->first('failed') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="post" class="form-validate" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="text-light">{{ trans('passwords.email') }}</label>
                                <div class="input-group text-light">
                                    <input type="email" class="form-control input-dark-bg text-light @error('email') is-invalid @enderror" name="email" placeholder="{{ trans('passwords.email') }}" value="{{ old('email') }}" autofocus="">
                                    <span class="input-group-text input-dark-bg"><i class="icon-mail"></i></span>
                                </div>
                                @error('email')
                                    <div class="is-invalid">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 mx-auto">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ trans('buttons.reset_pwd_send') }}
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
@endsection
