@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Variant') }}</h3>

                            @if(permissionCheck('variant.store'))
                            <ul class="d-flex">
                                <li><a data-toggle="modal" data-target="#Item_Details"
                                       class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"><i
                                            class="ti-plus"></i>{{ __('common.Add Variant') }}</a></li>
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
                                <div id="variant_list">
                                    @include('product::variant.variant_list')
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
                                <h4 class="modal-title">{{ __('common.Add Variant') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form method="POST" id="variantForm">
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Name') }} *</label>
                                                <input name="name" class="primary_input_field"
                                                       placeholder="Variant Name"
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
                                                               class="primary_checkbox d-flex mr-12 ">
                                                            <input name="status" value="1" type="radio" checked>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>Active</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="0" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>DeActive</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="status_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="QA_section2 QA_section_heading_custom check_box_table">
                                                <div class="QA_table mb_15">
                                                    <!-- table-responsive -->
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ __('common.Variation Values') }} </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="variant_row_lists">

                                                                <td class="pl-0 pb-0" style="border:0">
                                                                    <input class="placeholder_input"
                                                                           name="variant_values[]" placeholder="-"
                                                                           type="text">
                                                                </td>
                                                                <td class="pl-0 pb-0 pr-0" style="border:0">
                                                                    <div class="add_items_button pt-10">
                                                                        <button type="button"
                                                                                class="primary-btn radius_30px add_single_variant_row  fix-gr-bg">
                                                                            <i class="ti-plus"></i>{{ __('common.Add Value') }}
                                                                        </button>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"><i
                                                        class="ti-check"></i>{{ __('common.Add Variant') }}
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
                                <h4 class="modal-title">{{ __('common.Edit Variant') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="" method="POST" id="variantEditForm">
                                    <div class="row">
                                        <input type="text" style="display: none;" class="edit_id">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('common.Name') }} *</label>
                                                <input name="name" class="primary_input_field name"
                                                       placeholder="Variant Name"
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


                                        <div class="col-lg-12">
                                            <div class="QA_section2 QA_section_heading_custom check_box_table">
                                                <div class="QA_table mb_15">
                                                    <!-- table-responsive -->
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ __('common.Variation Values') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="variant_edit_row_lists">


                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"><i
                                                        class="ti-check"></i>{{ __('common.Edit Variant') }}
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
        @include('backEnd.partials.delete_modal')
    </section>
    @endsection
    @push('scripts')
        <script type="text/javascript">
         var baseUrl = $('#app_base_url').val();
            $(document).ready(function () {

                $(document).on('click', '.remove', function () {
                    $(this).parents('.variant_row_lists').remove();
                });

                $(document).ready(function () {
                    $('.add_single_variant_row').click(function () {
                        $('.variant_row_lists:last').after(`<tr class="variant_row_lists">
                            <td class="pl-0 pb-0" style="border:0">
                                    <input class="placeholder_input" placeholder="-" name="variant_values[]" type="text">
                            </td>
                            <!--<td class="pl-0 pb-0 pr-0 remove" style="border:0">
                                <div class="items_min_icon "><i class="ti-trash"></i></div>-->
                          <td class="pl-0 pb-0 pr-0 remove" style="border:0">
                                <a class="primary-btn primary-circle fix-gr-bg plus_button"
                                   href="javascript:void(0)"> <i
                                        class="ti-trash"></i></a>
                            </td></tr>`);
                    });
                })

                $(document).on('click', '.remove_edit', function () {
                    $(this).parents('.variant_edit_row_lists').remove();
                });
                $(document).ready(function () {
                    $(document).on('click', '.add_single_variant_edit_row', function () {
                        $('.variant_edit_row_lists:last').after(`<tr class="variant_edit_row_lists">
                            <td class="pl-0 pb-0" style="border:0">
                                    <input class="placeholder_input" placeholder="-" name="add_variant_values[]" type="text">
                            </td>

<td class="pl-0 pb-0 pr-0 remove_edit" style="border:0">
                                <a class="primary-btn primary-circle fix-gr-bg plus_button"
                                   href="javascript:void(0)"> <i
                                        class="ti-trash"></i></a>
                            </td></tr>
`);
                    });
                })

                $(document).on("submit", "#variantForm", function (event) {
                    event.preventDefault();
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        if (formData[key].name !== 'variant_values[]') {
                            $("#" + formData[key].name + "_error").html("");
                        }
                    });
                    $.ajax({
                        url: "{{route('variant.store')}}",
                        data: formData,
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#Item_Details").modal("hide");
                            $("#variantForm").trigger("reset");
                            variantList();
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

                $(document).on("submit", "#variantEditForm", function (event) {
                    event.preventDefault();
                    let id = $(".edit_id").val();
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        if (formData[key].name == 'edit_variant_values[]' || formData[key].name == 'add_variant_values[]') {

                        } else{
                            $("#edit_" + formData[key].name + "_error").html("");
                        }

                    });
                    $.ajax({
                        url: baseUrl + "/product/variant/" + id,
                        data: formData,
                        type: "PUT",
                        dataType: "JSON",
                        success: function (response) {
                            $("#Item_Edit").modal("hide");
                            $("#variantEditForm").trigger("reset");
                            $(".active").attr("checked", false);
                            $(".de_active").attr("checked", false);
                            variantList();
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

                $("#variant_list").on("click", ".edit_variant", function () {
                    let id = $(this).data("value");
                    $(".variant_edit_row_lists").html("");
                    $.ajax({
                        url: baseUrl + "/product/variant/" + id + "/edit",
                        type: "GET",
                        success: function (response) {
                            $(".edit_id").val(response.id);
                            $(".name").val(response.name);
                            $(".description").val(response.description);
                            if (response.values.length !== 0) {
                                $.each(response.values, function (key, items) {
                                    if (key === 0) {
                                        $('.variant_edit_row_lists:last').after(`<tr class="variant_edit_row_lists">
                                            <td class="pl-0 pb-0" style="border:0">
                                                    <input class="placeholder_input" value="${items.value}" placeholder="-" name="edit_variant_values[${items.id}]" type="text">
                                            </td>
                                             <td class="pl-0 pb-0 pr-0" style="border:0">
                                                <div class="add_items_button pt-10">
                                                    <button type="button" class="primary-btn radius_30px add_single_variant_edit_row  fix-gr-bg">
                                                        <i class="ti-plus"></i>Add Value
                                                    </button>
                                                </div>
                                            </td>
                                         </tr>`);
                                    } else {
                                        $('.variant_edit_row_lists:last').after(`<tr class="variant_edit_row_lists">
                                        <td class="pl-0 pb-0" style="border:0">
                                                <input class="placeholder_input" value="${items.value}" placeholder="-" name="edit_variant_values[${items.id}]" type="text">
                                        </td>
                                        ${items.used ? '' : '<td class="pl-0 pb-0 pr-0 remove_edit" style="border:0"> <a class="primary-btn primary-circle fix-gr-bg plus_button" href="javascript:void(0)"> <i class="ti-trash"></i></a> </td>'}
</tr>`);
                                    }
                                });
                            } else {
                                $('.variant_edit_row_lists:last').after(`<tr class="variant_edit_row_lists">
                                          <td class="pl-0 pb-0" style="border:0">
                                            <input class="placeholder_input"
                                                   name="add_variant_values[]" placeholder="-"
                                                   type="text">
                                            </td>
                                        <td class="pl-0 pb-0 pr-0" style="border:0">
                                            <div class="add_items_button pt-10">
                                                <button type="button" class="primary-btn radius_30px add_single_variant_edit_row  fix-gr-bg">
                                                    <i class="ti-plus"></i>Add Value
                                                </button>
                                            </div>
                                        </td></tr>`);
                            }


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

                $("#myInput").keyup(function (event) {
                    var search_keyword = $(this).val();
                    if (event.keyCode === 13) {
                        $.ajax({
                            url: "{{route("variant.get_list")}}" + '?search_keyword=' + search_keyword,
                            type: "GET",
                            dataType: "HTML",
                            success: function (response) {
                                $("#variant_list").html(response);
                                CRMTableThreeReactive()
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    }
                });

                function variantList() {
                    $.ajax({
                        url: "{{route("variant.get_list")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#variant_list").html(response);
                            CRMTableThreeReactive();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }

            });

        </script>
    @endpush
