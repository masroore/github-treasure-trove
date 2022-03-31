@extends('layouts.frontend')

@section('content')

<section class="my-account-cards-intro banner-block">
    <div class="d-flex flex-column align-items-center justify-content-center info text-center col-lg-6 offset-lg-3 px-lg-3">
        <h1>Register</h1>
        <p>Shopping for your business? <br> Create a <a href="b2b-account.php" class="color-red" title="B2b Account">business account</a>.</p>
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
                <input type="text" class="form-control" id="nameLastInput" placeholder="Last Name">
                <label for="nameLastInput">Last Name</label>
            </div>
            <div class="form-group form-floating">
                <input type="text" class="form-control" id="emailInput" placeholder="E-mail">
                <label for="emailInput">E-mail</label>
            </div>
            <div class="form-group form-floating">
                <input type="text" class="form-control" id="phoneInput" placeholder="Phone">
                <label for="phoneInput">Phone</label>
            </div>
            <div class="form-group form-floating">
                <input type="text" class="form-control" id="passwordInput" placeholder="Password">
                <label for="passwordInput">Password</label>
            </div>
            <div class="form-group form-floating">
                <input type="text" class="form-control" id="repeatPasswordInput" placeholder="RepeatPassword">
                <label for="repeatPasswordInput">Repeat Password</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="newsletterCheck" checked>
                <label class="custom-control-label" for="newsletterCheck">Subscribe to our newsletter and don't miss any deal!</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="agreeTermsCheck" checked>
                <label class="custom-control-label" for="agreeTermsCheck">I have read and agree to the <a href="#" title="Privacy Policy" class="color-red">Privacy Policy</a></label>
            </div>
            <a href="#" title="Create an Account" class="btn btn-primary w-100 my-4">Create an Account</a>
            <div class="mt-2 text-center ">Already have an account? <a href="{{route('login')}}" title="login" class="color-red">Sign in.</a></div>
        </div>
    </div>
</section>

@endsection