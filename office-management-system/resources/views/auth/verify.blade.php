@extends('auth.layouts.app')

@section('content')

    <section class="login-area up_login">
        <div class="row justify-content-center d-block d-md-block">
            <div class="col-lg-12 text-center">
                <p  style="margin-top: 25px !important;"></p>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <p class="mb-2 h6">
                                {{ __('Before proceeding, please check your email for a verification link Login in Using that Link.') }}
                            </p>
                            <form method="POST" class="" action="{{ route('verification_mail_resend') }}">
                                @csrf
                                <div class="col-8 col-offset-2">
                                    <button type="submit" class="primary-btn fix-gr-bg">
                                        <span class="ti-lock mr-2"></span>
                                        {{ __('Resend Mail') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
