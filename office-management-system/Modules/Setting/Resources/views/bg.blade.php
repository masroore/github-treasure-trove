@extends('setting::layouts.master')
@section('page-title', app('general_setting')->site_title .' | Settings')
@section('mainContent')
    @include("backEnd.partials.alertMessage")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('setting.Settings') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {!! Form::open(['url' => route('guest-background'), 'method' => 'post', 'id' => 'updateLoginBG', 'files' =>true ]) !!}
                    @csrf
                    <input type="hidden" name="g_set" value="1">

                    <div class="General_system_wrap_area bg_grib d-flex">
                        <div class="single_system_wrap">
                            <div class="single_system_wrap_inner text-center">
                                <div class="logo ">
                                    <span>{{ __('setting.Login Background Image') }}</span>
                                </div>
                                <div class="logo_img ml-auto mr-auto">
                                    <img class="img-fluid h-100" src="{{ asset( $setting->login_bg ) }}"
                                         alt="{{ asset( $setting->login_bg ) }}" id="login_bg">
                                </div>
                                <div class="update_logo_btn">
                                    <button class="primary-btn small fix-gr-bg " type="button">
                                        <input placeholder="Upload Image" type="file" name="login_bg"
                                               onchange="imageChangeWithFile(this, '#login_bg' )">
                                        {{ __('setting.Upload Image') }}
                                    </button>
                                </div>

                            </div>
                        </div>


                        <div class="single_system_wrap">
                            <div class="single_system_wrap_inner text-center">
                                <div class="logo ">
                                    <span>{{ __('setting.Error Page Background Image') }}</span>
                                </div>
                                <div class="logo_img ml-auto mr-auto">
                                    <img class="img-fluid" src="{{ asset( $setting->error_page_bg ) }}"
                                         alt="{{ __('setting.Error Page Background Image') }}" id="error_page_bg">
                                </div>
                                <div class="update_logo_btn">
                                    <button class="primary-btn small fix-gr-bg " type="button">
                                        <input placeholder="Upload Image" type="file" name="error_page_bg"
                                               onchange="imageChangeWithFile(this, '#error_page_bg' )">
                                        {{ __('setting.Upload Image') }}
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="submit_btn text-center mt-4">
                        <button class="primary_btn_large submit" type="submit"><i
                                class="ti-check"></i>{{ __('common.Save') }}
                        </button>

                        <button class="primary_btn_large submitting" type="submit" disabled style="display: none;"><i
                                class="ti-check"></i>{{ __('common.Saving') }}
                        </button>

                    </div>
    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    @endsection
