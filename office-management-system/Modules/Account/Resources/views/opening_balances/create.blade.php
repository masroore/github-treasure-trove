@extends('backEnd.master')
@section('mainContent')
    <div id="add_payment">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('common.Add New') }} {{ __('account.Opening Balance') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{ route('openning_balance.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('account.Account') }} <span>*</span></label>
                                            <div class="primary_datepicker_input">
                                                    
                                                     <select class="primary_select mb-15" name="account_id" id="asset_account_id" required>
                                                        <option value="">{{ __('common.Select one') }}</option>
                                                        @foreach ($assetAccounts as $key => $assetAccount)
                                                            <option value="{{ $assetAccount->id }}">{{ $assetAccount->name }}</option>
                                                        @endforeach
                                                    </select>


                                            </div>
                                            <span class="text-danger">{{$errors->first('time_period_id')}}</span>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('common.Date') }} <span>*</span></label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="startDate" type="text" name="date" value="" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                     <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('account.Amount') }} <span>*</span> </label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="{{ __('account.Amount') }}" class="primary_input_field primary-input form-control" id="amount" type="text" name="amount" value="" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('account.Account Type') }} <span>*</span></label>
                                            <div class="primary_datepicker_input">
                                                    
                                                     <select class="primary_select mb-15" name="type" id="type" required>
                                                        <option value="asset">{{ __('account.Asset') }}</option>
                                                        <option value="liability">{{ __('account.Liability') }}</option>
                                                       
                                                    </select>


                                            </div>
                                            <span class="text-danger">{{$errors->first('type')}}</span>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <label class="h1 primary_input_label text-center gradient-color2" for="" id="alert_txt"></label>
                                        <span class="text-danger">{{$errors->first('assetamount')}}</span>
                                        <div class="submit_btn text-center ">
                                            <button class="primary-btn semi_large2 fix-gr-bg" id="save"><i class="ti-check"></i>{{__("common.Save")}}</button>
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
@endsection

@push("scripts")
    
@endpush
