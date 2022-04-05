@extends('auth.layouts.guest', ['title' => __('common.Forgot your password?')])

@section('content')


    <h3 class="sho_web d-none d-md-block">{{ __('common.Forgot your password?') }}</h3>

    <p> {{ __('common.forgot_message') }}</p>


    <form  method="POST" action="{{ route('password.email') }}"  id="content_form" class="customer-input" >

        @csrf

        <input required name="email" type="text" placeholder="{{ __('common.Enter Email address') }}" id="email" autofocus class="" autocomplete="current-password">



        <button type="submit" class="login-res-btn submit">{{ __('common.Send Instruction') }}</button>
        <button type="button" class="login-res-btn submitting" style="display:none" disabled>{{ __('common.Sending Instructions') }}...</button>
    </form>
    <div class="text-left">
        <span class=""> {{ __('common.back_to') }}</span>
        <a href="{{ route('login') }}">{{ __('common.Login') }}</a>
    </div>

@endsection
