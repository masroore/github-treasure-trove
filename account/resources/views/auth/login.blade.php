@extends('layouts.auth')
@php
    $logo=asset(Storage::url('uploads/logo/'));
 $company_logo=Utility::getValByName('company_logo');
@endphp
@section('page-title')
    {{__('Login')}}
@endsection
@section('content')
    <div class="login-contain">
        <div class="login-inner-contain">
            <a class="navbar-brand" href="#">
                <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" class="navbar-brand-img big-logo" alt="logo">
            </a>
            <div class="login-form">
                <ul class="login-menu">
                    <li class="blue-login"><a href="{{route('login')}}">{{__('User Login')}}</a></li>
                    <li class="gray-login"><a href="{{route('customer.login')}}">{{__('Customer Login')}}</a></li>
                    <li class="gray-login"><a href="{{route('vender.login')}}">{{__('Vendor Login')}}</a></li>
                </ul>
                <div class="page-title"><h5><span>{{__('User')}}</span> {{__('Login')}}</h5></div>
                {{Form::open(array('route'=>'login','method'=>'post','id'=>'loginForm' ))}}
                @csrf
                <div class="form-group">
                    <label for="email" class="form-control-label">{{__('Email')}}</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-control-label">{{__('Password')}}</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password">
                    @error('password')
                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-primary">{{ __('Forgot Your Password?') }}</a>
                @endif

                <button type="submit" class="btn-login">{{__('Login')}}</button>
                <div class="or-text">{{__('OR')}}</div>
                <small class="text-muted">{{__("Don't have an account?")}}</small>
                <a href="{{ route('register') }}" class="text-xs text-primary">{{__('Register')}}</a>
                {{Form::close()}}
            </div>

            <h5 class="copyright-text">
                Copyright SERP 2021
                <?php
                    if(0){
                ?>
                {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright AccountGo') }} {{ date('Y') }}
                <?php
                    }
                ?>
            </h5>
            <div class="all-select">
                <a href="#" class="monthly-btn">
                    <span class="monthly-text py-0">{{__('Change Language')}}</span>
                    <select class="select-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
                        @foreach(Utility::languages() as $language)
                            <option @if($lang == $language) selected @endif value="{{ route('login',$language) }}">{{Str::upper($language)}}</option>
                        @endforeach
                    </select>
                </a>
            </div>
        </div>
    </div>
@endsection
