@extends('layouts.app')

@section('title', trans('register.title'))

@section('content')
    <section class="pt-5 pb-5 background-dark body-min-height">
        <div class="container-fluid d-flex flex-column">
            <div class="row align-items-center">
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <div class="card shadow-lg background-black-dark border-panel">
                        <div class="card-body py-5 px-sm-5">
                            <h3 class="text-primary">{{ trans('register.page_title') }}</h3>
                            <p>{{ trans('register.page_title_desc') }}</p>
                            <hr>
                            <form method="post" id="register_form" class="form-validate mt-5" action="{{ route('register') }}">
                                @csrf

                                <div class="h5 mb-4 text-light">{{ trans('register.sub_title') }}</div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="login_id" class="text-light">{{ trans('register.login_id') }}</label>
                                        <input type="text" class="form-control text-light input-dark-bg @error('login_id') is-invalid @enderror" name="login_id" placeholder="{{ trans('register.login_id') }}" value="{{ old('login_id') }}" autofocus>
                                        @error('login_id')
                                        <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name" class="text-light">{{ trans('register.name') }}</label>
                                        <input type="text" class="form-control text-light input-dark-bg @error('name') is-invalid @enderror" name="name" placeholder="{{ trans('register.name') }}" value="{{ old('name') }}">
                                        @error('name')
                                        <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="email" class="text-light">{{ trans('register.email') }}</label>
                                        <input type="email" class="form-control text-light input-dark-bg @error('email') is-invalid @enderror" name="email" placeholder="{{ trans('register.email') }}" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="password" class="text-light">{{ trans('register.password') }}</label>
                                        <div class="input-group show-hide-password">
                                            <input class="form-control text-light input-dark-bg @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('register.password') }}" value="{{ old('password') }}" type="password" >
                                            <span class="input-group-text input-dark-bg text-light"><i class="icon-eye-off" aria-hidden="true" style="cursor: pointer;"></i></span>
                                        </div>
                                        @error('password')
                                            <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation" class="text-light">{{ trans('register.password_confirmation') }}</label>
                                        <div class="input-group show-hide-password">
                                            <input class="form-control text-light input-dark-bg" name="password_confirmation" placeholder="{{ trans('register.password_confirmation') }}" type="password" >
                                            <span class="input-group-text input-dark-bg text-light"><i class="icon-eye-off" aria-hidden="true" style="cursor: pointer;"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="gender" class="text-light">{{ trans('register.gender') }}</label>
                                        <select class="form-select text-light input-dark-bg" name="gender" >
                                            <option>Select your gender</option>
                                            @foreach($gender_list as $gender_info)
                                                <option value="{{ $gender_info['id'] }}" @if( old('gender') == $gender_info['id']) selected @endif>{{ trans('common.gender.'.$gender_info['gender']) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="birthday" class="text-light">{{ trans('register.birthday') }}</label>
                                        <div class="input-group date" id="datepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#datepicker" name="birthday" value="{{ old('birthday') }}"  placeholder="{{ trans('common.date_placeholder') }}" />
                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="mobile" class="text-light">{{ trans('register.mobile') }}</label>
                                        <input class="form-control text-light input-dark-bg @error('mobile') is-invalid @enderror" type="tel" name="mobile" placeholder="{{ trans('register.mobile') }}" value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="country" class="text-light">{{ trans('register.country') }}</label>
                                        <select name="country" class="form-select text-light input-dark-bg @error('country') is-invalid @enderror" >
                                            <option value="">{{ trans('register.country_placeholder') }}</option>
                                            @foreach($country_list as $code => $country_info)
                                                <option value="{{ $country_info['name'] }}" @if( old('country') == $country_info['name']) selected @endif>{{ $country_info['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lang" class="text-light">{{ trans('register.lang') }}</label>
                                        <select name="lang" class="form-select text-light input-dark-bg @error('lang') is-invalid @enderror" >
                                            <option value="">{{ trans('register.lang_placeholder') }}</option>
                                            @foreach($language_list as $language_info)
                                                <option value="{{ $language_info['code'] }}" @if( old('lang') == $language_info['code']) selected @endif>{{ $language_info['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('lang')
                                            <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="address" class="text-light">{{ trans('register.address') }}</label>
                                        <input type="text" class="form-control text-light input-dark-bg @error('address') is-invalid @enderror" name="address" placeholder="{{ trans('register.address') }}" value="{{ old('address') }}">
                                        @error('address')
                                            <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="postal_code" class="text-light">{{ trans('register.postal_code') }}</label>
                                        <input type="text" class="form-control text-light input-dark-bg @error('postal_code') is-invalid @enderror" name="postal_code" placeholder="{{ trans('register.postal_code') }}" value="{{ old('postal_code') }}">
                                        @error('postal_code')
                                            <div class="is-invalid">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-check mb-1 mt-5">
                                    <input type="checkbox" name="agree" id="agree" class="form-check-input" value="{{ old('agree') }}" required>
                                    <label class="form-check-label text-light" for="agree">{{ trans('register.agree_desc') }}</label>
                                </div>
                                <button type="submit" class="btn m-t-30 mt-3">{{ trans('buttons.register') }}</button>
                            </form>
                            <div class="mt-4"><small>{{ trans('register.already_desc') }}</small> <a href="{{route('login')}}" class="small fw-bold">{{ trans('buttons.login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <!--Bootstrap Datetimepicker component-->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datetimepicker/tempusdominus-bootstrap-4.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            $('#datepicker').datetimepicker({
                format: 'L'
            });
        });
	
        $( document ).ready(function() {
            $('#top_register').addClass('text-danger');
        });
    </script>
@endsection
