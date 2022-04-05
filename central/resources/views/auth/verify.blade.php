@extends('layouts.app')

@section('title', trans('emailverification.title'))

@section('content')
<section class="pt-5 pb-5 background-dark background-theme body-min-height">
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="card background-black-dark border-panel">
                    <div class="card-body py-5 px-sm-5">
                        <div class="text-center">
                            <h3 class="text-primary">{{ trans('emailverification.page_title') }}</h3>
                        </div>
                        <hr>
                        @if (session('resent'))
                            <div class="alert alert-success alert-dismissible fade show" id="success_div">
                                {{ trans('emailverification.sent_success_msg') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <p>{{ trans('emailverification.desc1') }}<br>
                            {{trans('emailverification.desc2') }},</p>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="form-group row mb-0">
                                <div class="col-md-6 mx-auto">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ trans('emailverification.request_email') }}
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
