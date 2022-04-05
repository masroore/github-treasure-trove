@extends('layouts.admin')
@section('title', 'users')
@section('content')
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

                        <h6 class="h2 d-inline-block mb-0">{{ __('Profile') }}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboards') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="#" class="btn btn-sm btn-neutral">{{ __('New') }}</a>
                        <a href="#" class="btn btn-sm btn-neutral">{{ __('Filters') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        @php
            $profile = asset(Storage::url('uploads/avatar/'));
        @endphp
        {{-- @section('page-title')
    {{__('Profile Account')}}
@endsection --}}

        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">
                <div class="card profile-card">
                    <div class="icon-user avatar rounded-circle">

                        <img alt=""
                            src="{{ !empty($users->avatar) ? $profile . '/' . $users->avatar : $profile . '/avatar.png' }}"
                            class="">

                </div>
                <h4 class=" h4 mb-0 mt-2">
                        {{ $users->name }}
                        </h4>
                        <div class="sal-right-card">
                            <span class="badge badge-pill badge-blue">Company</span>
                        </div>
                        <h6 class="office-time mb-0 mt-4">{{ $users->email }}</h6>


                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
                    <section class="col-lg-12 pricing-plan card">
                        <div class="our-system password-card p-3">
                            <div class="row">
                                <!-- <div class="col-lg-12"> -->

                                <ul class="nav nav-tabs my-4">
                                    <li>
                                        <a data-toggle="tab" href="#Biling"
                                            class="active">{{ __('Personal info') }}</a>
                                    </li>
                                    <li class="annual-billing">
                                        <a data-toggle="tab" href="#Billing2"
                                            class="">{{ __('Change Password') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- </div> -->
                        <div class="
                                            tab-content">
                                            <div id="Biling" class="tab-pane in active">
                                                {{ Form::model($users, ['route' => ['update.account'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="form-group">
                                                            {{ Form::label('name', __('Name'), ['class' => 'form-control-label']) }}
                                                            {{ Form::text('name', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter User Name')]) }}
                                                            @error('name')
                                                                <span class="invalid-name" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="form-group">
                                                            {{ Form::label('email', __('Email'), ['class' => 'form-control-label']) }}
                                                            {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter User Email')]) }}
                                                            @error('email')
                                                                <span class="invalid-email" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{-- @if (!$customFields->isEmpty())
                                        <div class="col-lg-6 col-md-6">
                                            <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                                @include('customFields.formBuilder')
                                            </div>
                                        </div> 
                                    @endif --}}

                                                    <div class="col-lg-6 col-md-6">

                                                        <div class="form-group">
                                                            <div class="choose-file">
                                                                <label for="avatar">
                                                                    <div>{{ __('Choose file here') }}</div>
                                                                    <input type="file" class="form-control" id="avatar"
                                                                        name="profile" data-filename="profiles">
                                                                </label>
                                                                <p class="profiles"></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 text-right">
                                                        <input type="submit" value="{{ __('Save Changes') }}"
                                                            class="btn-create badge-blue">
                                                    </div>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                            <div id="Billing2" class="tab-pane">
                                                {{ Form::model($users, ['route' => ['update.password', $users->id], 'method' => 'post']) }}
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="form-group">
                                                            {{ Form::label('current_password', __('Current Password'), ['class' => 'form-control-label']) }}
                                                            {{ Form::password('current_password', ['class' => 'form-control', 'placeholder' => __('Enter Current Password')]) }}
                                                            @error('current_password')
                                                                <span class="invalid-current_password" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="form-group">
                                                            {{ Form::label('new_password', __('New Password'), ['class' => 'form-control-label']) }}
                                                            {{ Form::password('new_password', ['class' => 'form-control', 'placeholder' => __('Enter New Password')]) }}
                                                            @error('new_password')
                                                                <span class="invalid-new_password" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            {{ Form::label('confirm_password', __('Re-type New Password'), ['class' => 'form-control-label']) }}
                                                            {{ Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => __('Enter Re-type New Password')]) }}
                                                            @error('confirm_password')
                                                                <span class="invalid-confirm_password" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-right">
                                                        <input type="submit" value="{{ __('Save Changes') }}"
                                                            class="btn-create badge-blue">
                                                    </div>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                            </div>


                        </div>
                </div>
                </section>

            </div>
        </div>
    </div>
@endsection
