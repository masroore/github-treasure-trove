@extends('auth.layouts.guest', ['title' => __('common.Reset Password')])

@section('content')
<h3 class="sho_web d-none d-md-block">{{ __('common.Reset Password') }}</h3>

<form  method="POST" action="{{ route('password.update') }}"  id="content_form" class="customer-input" >

    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input required name="email" type="text" placeholder="{{ __('common.Enter Email address') }}" autofocus value="{{ $email ?? old('email') }}" autocomplete="current-password">
    <input required name="password" type="password" placeholder="{{ __('common.New Password') }}" id="password" autofocus class="" autocomplete="current-password">
    <input required name="password_confirmation" type="password" placeholder="{{ __('common.Confirm New Password') }}" id="password_confirmation" autofocus class="" autocomplete="current-password">

    <button type="submit" class="login-res-btn submit">{{ __('common.Reset Password') }}</button>
    <button type="button" class="login-res-btn submitting" style="display:none" disabled>{{ __('common.Resetting Password') }}...</button>
</form>

@endsection
