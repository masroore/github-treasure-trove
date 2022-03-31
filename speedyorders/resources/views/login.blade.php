@extends('layouts.frontend')

@section('content')

<section class="my-account-cards-intro banner-block">
    <div class="d-flex flex-column align-items-center justify-content-center info text-center col-lg-6 offset-lg-3 px-lg-3">
        <h1>Login</h1>
        <p>Welcome back!</p>
    </div>
    <picture>
        <source media="(max-width: 767px)" srcset="frontend_assets/img/base_layout/m-account-intro.jpg">
        <img src="frontend_assets/img/base_layout/account-intro.jpg" alt="">
    </picture>
</section>

<section class="container mb-5">
    <div class="row">
        <div class="col-md-8 col-lg-6 col-xl-4 mx-auto">
            <div class="form-group form-floating">
                <input type="text" class="form-control" id="nameInput" placeholder="First Name">
                <label for="nameInput">First Name</label>
            </div>
            <div class="form-group form-floating">
                <input type="text" class="form-control" id="passwordInput" placeholder="Password">
                <label for="passwordInput">Password</label>
            </div>
            <a href="#" title="Forgot your password?" class="color-red" style="font-size:14px;">Forgot your password?</a>
            <a href="{{route('login')}}" title="Sign In" class="btn btn-primary w-100 my-4">Sign In</a>
            <div class="mt-2 text-center ">Don't have an account? <a href="{{route('register')}}" title="login" class="color-red">Sign up.</a></div>
        </div>
    </div>
</section>


@endsection