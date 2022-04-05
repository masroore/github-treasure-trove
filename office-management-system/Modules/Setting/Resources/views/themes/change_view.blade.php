@extends('backEnd.master')

@section('mainContent')
    <div id="contact_settings">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('common.Change View') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{ route('themes.change_view') }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @if ($errors->has('view'))
                                        <div class="col-12">
                                            <div class="alert alert-danger text-center" role="alert">
                                                <strong>{{ $errors->first('view') }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-3 d-flex">
                                                <p class="text-uppercase fw-500 mb-10">{{__('common.Change View')}} </p>
                                            </div>
                                            <div class="col-lg-9">

                                                <div class="radio-btn-flex ml-20">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="">
                                                                <input type="radio" name="view" id="normal" value="normal" class="common-radio relationButton" {{ ($default_view == 'normal') ? 'checked' : ''}} >
                                                                <label for="normal">{{__('common.Normal View')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="">
                                                                <input type="radio" name="view" id="compact" value="compact" {{ ($default_view == 'compact') ? 'checked' : ''}} class="common-radio relationButton" >
                                                                <label for="compact">{{__('common.Compact View')}}</label>
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
