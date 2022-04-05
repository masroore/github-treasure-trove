@extends('backEnd.master')
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
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.Discount Coupon List') }}</h3>
                            @if (permissionCheck('null'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"  data-toggle="modal" data-target="#Coupon_Add"><i class="ti-plus"></i>{{ __('common.Add New') }} {{ __('product.Coupon') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('product.Coupon') }}</th>
                                        <th scope="col">{{ __('product.Discount Type') }}</th>
                                        <th scope="col">{{ __('product.Cause') }}</th>
                                        <th scope="col">{{ __('product.Date From') }}</th>
                                        <th scope="col">{{ __('product.Date Till') }}</th>
                                        <th scope="col">{{ __('product.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($coupons as $key => $coupon)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $coupon->code }}</td>
                                            <td>{{ $coupon->discount_type }}</td>
                                            <td>{{ $coupon->cause }}</td>
                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime($coupon->start_date)) }}</td>
                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime($coupon->end_date)) }}</td>
                                            <td>{{ $coupon->status }}</td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        <a href="#" data-toggle="modal" data-target="#Item_Edit" class="dropdown-item edit_brand" onclick="edit_division_modal({{ $coupon->id }})">{{__('common.Edit')}}</a>
                                                     
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="edit_form">

    </div>
    <div class="modal fade admin-query" id="Coupon_Add">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Add New') }} {{ __('product.Coupon') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" method="POST" id="coupon_addForm">
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('product.Code') }}</label>
                                    <input name="code" class="primary_input_field name" placeholder="{{ __('product.Code') }}" type="text">
                                    <span class="text-danger" id="code_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('product.Discount Type') }}</label>
                                    <select class="primary_select mb-25" name="discount_type" id="discount_type" required>
                                        <option value="1">{{ __('product.Active') }}</option>
                                        <option value="2">{{ __('product.Expired') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('product.Date From') }}</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date" class="primary_input_field primary-input date form-control" id="startDate" type="text" name="start_date" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('product.Date Till') }}</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date" class="primary_input_field primary-input date form-control" id="endDate" type="text" name="end_date" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('product.Cause') }}</label>
                                    <input name="cause" class="primary_input_field name" placeholder="{{ __('product.Cause') }}" type="text">
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Status') }}</label>
                                    <select class="primary_select mb-25" name="status" id="status">
                                        <option value="1">{{ __('product.Active') }}</option>
                                        <option value="2">{{ __('product.Expired') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">

        $("#coupon_addForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("coupon.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#coupon_addForm").modal("hide");
                    $("#coupon_addForm").trigger("reset");
                    location.reload();
                },
                error: function (error) {
                    if (error) {
                        $.each(error.responseJSON.errors, function (key, message) {
                            $("#" + key + "_error").html(message[0]);
                        });
                    }
                }

            });
        });
        function edit_division_modal(el){
            toastr.error("Not Implemented Update and Delete");
        }
    </script>
@endpush
