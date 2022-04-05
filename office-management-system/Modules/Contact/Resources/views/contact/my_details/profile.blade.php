@extends('backEnd.master')
@section('mainContent')
    <section class="mb-40 student-details">
        @if(session()->has('message-success'))
            <div class="alert alert-success">
                {{ session()->get('message-success') }}
            </div>
        @elseif(session()->has('message-danger'))
            <div class="alert alert-danger">
                {{ session()->get('message-danger') }}
            </div>
        @endif
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Start Student Meta Information -->
                    <div class="main-title">
                        <h3 class="mb-20">@lang('common.'.$user->contact_type)</h3>
                    </div>
                    <div class="student-meta-box ">
                        <div class="student-meta-top"></div>
                        <img class="student-meta-img img-100"
                             src="{{ file_exists($user->avatar) ? asset($user->avatar) : asset('public/img/profile.jpg') }}"
                             alt="">
                        <div class="white-box radius-t-y-0">
                            <div class="single-meta mt-10">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        {{ __('common.Name') }}
                                    </div>
                                    <div class="value">
                                        @if(isset($user)){{@$user->user->name}}@endif
                                    </div>
                                </div>
                            </div>
                           
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('contact.Contact Id') }}
                                        </div>
                                        <div class="value">
                                           {{ @$user->contact_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('common.Opening Balance') }}
                                        </div>
                                        <div class="value">
                                            @if(isset($user)){{single_price($user->opening_balance)}}@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">
                                            {{ __('common.Tax Number') }}
                                        </div>
                                        <div class="value">
                                            {{ $user->tax_number }}
                                        </div>
                                    </div>
                                </div>
                          
                            
                        </div>
                    </div>
                    <!-- End Student Meta Information -->
                </div>
                <!-- Start Student Details -->
                <div class="col-lg-9 staff-details">
                    <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#studentProfile" role="tab"
                               data-toggle="tab">{{ __('common.Profile') }}</a>
                        </li>
                        
                        <li class="nav-item edit-button">
                            <a href="#" class="primary-btn small fix-gr-bg"
                               data-toggle="modal" data-target="#profileEditForm">{{ __('common.Edit') }}
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Start Profile Tab -->
                        <div role="tabpanel" class="tab-pane fade show active" id="studentProfile">
                            <div class="white-box">
                                <h4 class="stu-sub-head">{{ __('common.Personal Info') }}</h4>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                {{ __('common.Business Name') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{$user->business_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                {{ __('common.Mobile') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                @if(isset($user)){{$user->mobile}}@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                {{ __('common.Email') }}
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                @if(isset($user)){{@$user->email}}@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                    
                                    <!-- Start Parent Part -->
                                    <h4 class="stu-sub-head mt-40">{{ __('common.Address') }}</h4>
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    {{ __('common.Current Address') }}
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    {{ $user->address. ', '. $user->city.', '.$user->state .', '. @$user->country->name  }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                            </div>
                        </div>
                        <!-- End Profile Tab -->
                 
                      
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="edit_form">

    </div>

    <div class="modal fade admin-query" id="profileEditForm">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Edit Profile') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contact.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Name') }} <span class="text-danger">*</span></label>
                                    <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" value="{{ $user->name }}" type="text">
                                </div>
                                @error('name')
                                {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('name'))}}
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Email') }} <span class="text-danger">*</span></label>
                                    <input name="email" class="primary_input_field name" placeholder="{{ __('common.Email') }}" value="{{ $user->email }}" type="email" readonly>
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                </div>
                            </div>

                

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Tax Number') }} </label>
                                    <input name="tax_number" value="{{$user->tax_number}}" class="primary_input_field name" placeholder="{{ __('common.Mobile') }}" type="tel">
                                    @error('tax_number')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('tax_number'))}}
                                    @enderror
                                </div>
                            </div>

                             <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Mobile') }} </label>
                                    <input name="mobile" value="{{$user->mobile}}" class="primary_input_field name" placeholder="{{ __('common.Mobile') }}" type="tel">
                                    @error('mobile')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('mobile'))}}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Password') }} </label>
                                    <input name="password" class="primary_input_field name" placeholder="{{ __('common.Password') }}" type="password" minlength="6">
                                    @error('password')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('password'))}}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Re-Password') }} </label>
                                    <input name="password_confirmation" class="primary_input_field name" placeholder="{{ __('common.Re-Password') }}" type="password" minlength="6">
                                     @error('password_confirmation')
                                    {{\Brian2694\Toastr\Facades\Toastr::error($errors->first('password_confirmation'))}}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('contact.Country') }}</label>
                                    <select class="primary_select mb-25" name="country_id" id="country_id">
                                        <option disabled selected>{{ __('contact.Select Country') }}</option>
                                        @foreach (\Modules\Setup\Entities\Country::all() as $key => $country)
                                             <option value="{{ $country->id }}"  @if ($country->id == $user->country_id) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                             <div class="col-lg-6">

                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('contact.State') }}</label>
                                        <input type="text" id="state" name="state"  class="primary_input_field"
                                               value="{{ $user->state }}">
                                               <span class="text-danger">{{$errors->first('state')}}</span>
                                    </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('contact.City') }}</label>
                                            <input type="text" id="city" name="city"  class="primary_input_field"
                                                   value="{{ $user->city }}">
                                                   <span class="text-danger">{{$errors->first('city')}}</span>
                                        </div>

                                    </div>

                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('common.Avatar') }}</label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input" type="text" id="placeholderFileTwoName" placeholder="Browse file" readonly="">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_2">{{ __('common.Browse') }}</label>
                                            <input type="file" class="d-none" name="file" id="document_file_2">
                                        </button>
                                    </div>
                                </div>

                            </div>
                        

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
