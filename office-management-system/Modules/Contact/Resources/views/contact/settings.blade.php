@extends('backEnd.master')

@section('mainContent')
<div id="contact_settings">
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('common.Settings') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <!-- Prefix  -->
                        <form action="{{ route('contact.settings') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-3 d-flex">
                                        <p class="text-uppercase fw-500 mb-10">{{__('common.Login Permission')}} </p>
                                    </div>
                                    <div class="col-lg-9">

                                        <div class="radio-btn-flex ml-20">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="">
                                                        <input type="radio" name="contact_login" id="relationFather" value="1" class="common-radio relationButton" {{ (app('general_setting')->first()->contact_login) ? 'checked' : ''}} >
                                                        <label for="relationFather">{{__('common.Enable')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="">
                                                        <input type="radio" name="contact_login" id="relationMother" value="0" {{ (app('general_setting')->first()->contact_login) ? '' : 'checked'}} class="common-radio relationButton" >
                                                        <label for="relationMother">{{__('common.Disable')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 text-center">
                                                    <button class="primary-btn fix-gr-bg" id="_submit_btn_admission">
                                                        <span class="ti-check"></span>
                                                        {{__('common.Save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@stop
