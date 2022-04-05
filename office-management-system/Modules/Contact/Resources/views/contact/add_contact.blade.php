@extends('backEnd.master')
@section('mainContent')
    @if(session()->has('message-success'))
        <div class="alert alert-success mb-25" role="alert">
            {{ session()->get('message-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('common.Add Contact')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{route("add_contact.store")}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row form">
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('common.Contact Type')}} *</label>
                                            <select class="primary_select mb-15 contact_type" name="contact_type">
                                                <option {{ old('contact_type') == 'Supplier' ? 'selected' : '' }}>{{__('contact.Supplier')}}</option>
                                                <option {{ old('contact_type') == 'Customer' ? 'selected' : '' }}>{{__('contact.Customer')}}</option>
                                            </select>
                                            <span class="text-danger">{{$errors->first('contact_type')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__("common.Name")}} *</label>
                                            <input class="primary_input_field" name="name" placeholder="{{__('contact.Name')}}" type="text" value="{{old('name')}}" required>
                                            <span class="text-danger">{{$errors->first('name')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('contact.Profile Picture')}}</label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="Browse file" readonly>
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_1">{{__("common.Browse")}} </label>
                                                    <input type="file" class="d-none" name="file" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('common.Business Name')}}</label>
                                            <input type="text" name="business_name" class="primary_input_field"
                                                   value="{{old('business_name')}}">
                                            <span class="text-danger">{{$errors->first('business_name')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('common.Tax Number')}}</label>
                                            <input type="text" name="tax_number" class="primary_input_field"
                                                   value="{{old('tax_number')}}">
                                            <span class="text-danger">{{$errors->first('tax_number')}}</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('common.Opening Balance')}}</label>
                                            <input type="text" name="opening_balance" class="primary_input_field"
                                                   value="{{old('opening_balance') ?? 0}}">
                                            <span class="text-danger">{{$errors->first('opening_balance')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('common.Pay Term')}} </label>
                                            <input type="text" name="pay_term" class="primary_input_field"
                                                   value="{{old('pay_term')}}">
                                            <span class="text-danger">{{$errors->first('pay_term')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('common.Pay Term Condition')}}</label>
                                            <select class="primary_select mb-15" id="sub_category_list" name="pay_term_condition">
                                                <option value="Months">Months</option>
                                                <option value="Days">Days</option>
                                            </select>
                                            <span class="text-danger">{{$errors->first('pay_term_condition')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 customer_type_section">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('common.Credit Limit')}}</label>

                                            <input type="text" name="credit_limit" class="primary_input_field" value="{{old('credit_limit')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 customer_type_section d-none">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('common.Customer Group')}}</label>
                                            <select class="primary_select mb-15"
                                                    name="customer_group">
                                                <option>{{__('contact.None')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('common.Email')}} @if(app('general_setting')->contact_login) * @endif</label>
                                            <input type="text" name="email" class="primary_input_field"
                                                   value="{{old('email')}}" @if(app('general_setting')->contact_login) required @endif>
                                            <span class="text-danger">{{$errors->first('email')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('common.Mobile')}} </label>
                                            <input type="text" name="mobile" class="primary_input_field"
                                                   value="{{old('mobile')}}" >
                                            <span class="text-danger">{{$errors->first('mobile')}}</span>
                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="">{{__('common.Alternate Contact No')}}</label>
                                            <input type="text" name="alternate_contact_no" class="primary_input_field"
                                                   value="{{old('alternate_contact_no')}}">

                                        </div>

                                    </div>
                                    @if(app('general_setting')->first()->contact_login)

                                    <div class="col-lg-4">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for="password">{{__('common.Password')}} ({{trans('Minimum 8 Letter')}}) *</label>
                                            <input type="text" id="password" name="password" required class="primary_input_field"
                                                   value="{{old('password')}}">
                                                   <span class="text-danger">{{$errors->first('password')}}</span>

                                        </div>

                                    </div>
                                    @endif

                                    <div class="col-lg-4">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('contact.Country') }}</label>
                                            <select class="primary_select mb-25" name="country_id" id="country_id">
                                                <option disabled selected>{{ __('contact.Select Country') }}</option>
                                                @foreach (\Modules\Setup\Entities\Country::all() as $key => $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('contact.State') }}</label>
                                            <input type="text" id="state" name="state"  class="primary_input_field"
                                                   value="{{old('state')}}">
                                                   <span class="text-danger">{{$errors->first('state')}}</span>
                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('contact.City') }}</label>
                                            <input type="text" id="city" name="city"  class="primary_input_field"
                                                   value="{{old('city')}}">
                                                   <span class="text-danger">{{$errors->first('city')}}</span>
                                        </div>

                                    </div>

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('common.Address')}}</label>
                                            <input class="primary_input_field" name="address" placeholder="Address" type="text" value="{{old('address')}}">
                                            <span class="text-danger">{{$errors->first('address')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="primary_input mb-40">
                                            <label class="primary_input_label" for=""> {{__('common.Note')}} </label>
                                            <textarea class="summernote" name="note"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="submit_btn text-center ">
                                        <button class="primary-btn semi_large2 fix-gr-bg" type="submit"><i
                                                class="ti-check"></i>{{__('common.Add Contact')}}
                                        </button>
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
    <script type="text/javascript">
        $(document).ready(function () {
            change_customer_to_supplier($(".contact_type").val())
            $(".contact_type").on('change', function () {
                let type = $(this).val();
                change_customer_to_supplier(type)
            });

            function change_customer_to_supplier(type){
                if (type === "Customer") {
                    $(".customer_type_section").show();
                } else {
                    $(".customer_type_section").hide();
                }
            }
            $('.summernote').summernote({
                height: 200
            });
        });




    </script>
@endpush
