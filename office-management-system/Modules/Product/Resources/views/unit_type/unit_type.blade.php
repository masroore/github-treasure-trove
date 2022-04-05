@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">

                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Unit Type') }}</h3>
                            @if(permissionCheck('unit_type.store'))
                            <ul class="d-flex">
                                <li><a data-toggle="modal" data-target="#Item_Details" class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"><i class="ti-plus"></i>{{ __('common.Add Unit Type') }}</a></li>
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route('unit_type.csv_upload')}}"><i class="ti-export"></i>{{__('common.Upload Via CSV')}}</a></li>
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
                                <div id="unit_type_list">
                                    @include('product::unit_type.unit_type_list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Modal Item_Details -->

                <div class="modal fade admin-query" id="Item_Details">
                    <div class="modal-dialog modal_800px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Add Unit Type') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="unitTypeForm">
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Name') }} *</label>
                                                <input name="name" class="primary_input_field"
                                                       placeholder="Unit Type Name"
                                                       type="text" required>
                                                <span class="text-danger" id="name_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Description') }}</label>
                                                <input name="description" class="primary_input_field"
                                                       placeholder="{{__('product.Put Some Description')}}" type="text">
                                                <span class="text-danger" id="description_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Status') }} *</label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="1" class="active" type="radio" checked>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{__('common.Active')}}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="0" class="de_active"
                                                                   type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{__('common.DeActive')}}</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="status_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"><i
                                                        class="ti-check"></i>{{ __('common.Update') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="Item_Edit">
                    <div class="modal-dialog modal_800px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Edit Unit Type') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="" id="unitTypeEditForm">
                                    <div class="row">
                                        <input type="text" style="display: none;" class="edit_id">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Name') }} *</label>
                                                <input name="name" class="primary_input_field name"
                                                       placeholder="Unit Type Name"
                                                       type="text" required>
                                                <span class="text-danger" id="edit_name_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Description') }}</label>
                                                <input name="description" class="primary_input_field description"
                                                       placeholder="{{__('product.Put Some Description')}}" type="text">
                                                <span class="text-danger" id="edit_description_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Status') }} *</label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="1" class="active" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>Active</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="0" class="de_active"
                                                                   type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>DeActive</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="edit_status_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"><i
                                                        class="ti-check"></i>{{ __('common.Edit Unit Type') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
        @include('backEnd.partials.delete_modal')
    </section>
    @push('scripts')
        <script type="text/javascript">
            var baseUrl = $('#app_base_url').val();
            $(document).ready(function () {

                $("#unitTypeForm").on("submit", function (event) {
                    event.preventDefault();
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        $("#" + formData[key].name + "_error").html("");
                    });
                    $.ajax({
                        url: "{{route("unit_type.store")}}",
                        data: formData,
                        type: "POST",
                        success: function (response) {
                            $("#Item_Details").modal("hide");
                            $("#unitTypeForm").trigger("reset");
                            unitTypeList();
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


                $("#unit_type_list").on("click", ".edit_unit_type", function () {
                    let id = $(this).data("value");
                    $.ajax({
                        url: baseUrl + "/product/unit_type/" + id + "/edit",
                        type: "GET",
                        success: function (response) {
                            $(".edit_id").val(response.id);
                            $(".name").val(response.name);
                            $(".description").val(response.description);
                            if (response.status === 1) {
                                $(".active").attr("checked", true);
                            } else {
                                $(".de_active").attr("checked", true);
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });


                $(document).on("submit", "#unitTypeEditForm", function (event) {
                    event.preventDefault();
                    let id = $(".edit_id").val();
                    console.log(id);
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        $("#edit_" + formData[key].name + "_error").html("");
                    });
                    $.ajax({
                        url: baseUrl + "/product/unit_type/" + id,
                        data: formData,
                        type: "PUT",
                        dataType: "JSON",
                        success: function (response) {
                            $("#Item_Edit").modal("hide");
                            $("#unitTypeEditForm").trigger("reset");
                            $(".active").attr("checked", false);
                            $(".de_active").attr("checked", false);
                            unitTypeList();
                        },
                        error: function (error) {
                            if (error) {
                                $.each(error.responseJSON.errors, function (key, message) {
                                    $("#edit_" + key + "_error").html(message[0]);
                                });
                            }
                        }
                    });
                });




                $("#myInput").keyup(function(event) {

                    var search_keyword = $(this).val();
                    if (event.keyCode === 13) {
                        $.ajax({
                            url: "{{route("unit_type.get_list")}}"+ '?search_keyword=' +search_keyword,
                            type: "GET",
                            dataType: "HTML",
                            success: function (response) {
                                $("#unit_type_list").html(response);
                                CRMTableThreeReactive()
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    }
                });

                function unitTypeList() {
                    $.ajax({
                        url: "{{route("unit_type.get_list")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#unit_type_list").html(response);
                            CRMTableThreeReactive()
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }


            });


        </script>
    @endpush
@endsection
