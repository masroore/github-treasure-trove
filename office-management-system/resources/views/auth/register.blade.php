@extends('auth.layouts.guest', ['title' => __('common.Registration')])


@section('content')

    <h3 class="sho_mb d-sm-block d-md-none">Welcome To {{ app('general_setting')->site_title }}</h3>

    <form method="POST" action="{{ route('register') }}" id="content_form" class="customer-input">

        @csrf

        <input required name="name" id="name" type="text" placeholder="Your Full Name" autofocus>
        <input required name="email" id="email" type="text" placeholder="Your email address" autofocus class=""
               autocomplete="current-password">

        <input required name="password" id="password" type="password" placeholder="Your Password" class="" value="">
        <input required name="password_confirmation" id="password_confirmation" type="password"
               placeholder="Confirm Your Password" class="" value="">


        <div class="forgot-pass justify-content-start">
            <div class="check-remamber-field">
                <div class="round">
                    <input type="radio" id="supplier" name="contact_type"
                           value="Supplier" {{ (old('contact_type') == 'Supplier') ? 'checked' : '' }} {{ (old('contact_type') != 'Customer') ? 'checked' : '' }}/>
                    <label for="supplier"></label>
                </div>
                <label class="remember-me ml-1" for="supplier">
                    {{__('contact.Supplier')}}
                </label>
            </div>
            <div class="check-remamber-field ml-5">
                <div class="round">
                    <input type="radio" id="customer" name="contact_type"
                           {{ (old('contact_type') == 'Customer') ? 'checked' : '' }} value="Customer"/>
                    <label for="customer"></label>
                </div>
                <label class="remember-me" for="customer">
                    {{__('contact.Customer')}}
                </label>
            </div>
        </div>

        <button type="submit" class="login-res-btn submit">{{ __('common.Register') }}</button>
        <button type="button" class="login-res-btn submitting" style="display:none"
                disabled>{{ __('common.Registering') }}...
        </button>
    </form>

    <div class="text-left">
        <span class=""> {{ __('common.back_to') }}</span>
        <a href="{{ route('login') }}">{{ __('common.Login') }}</a>
    </div>


@endsection
