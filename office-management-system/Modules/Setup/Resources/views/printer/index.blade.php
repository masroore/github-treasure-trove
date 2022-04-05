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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Printer') }}</h3>
                            @if(permissionCheck('printer.store'))
                            <ul class="d-flex">
                                <li><a data-toggle="modal" data-target="#Item_Details" class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"><i class="ti-plus"></i>{{ __('common.Add Printer') }}</a></li>
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
                                <div id="printer_list"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Modal Item_Details -->
                <div class="modal fade admin-query" id="Item_Details">
                    <div class="modal-dialog modal_800px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Add Printer') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form method="POST" id="modelTypeForm">
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                                <input name="name" class="primary_input_field" placeholder="Printer Name"
                                                       type="text" required>
                                                <span class="text-danger" id="name_error"></span>
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Connection Type') }} *</label>
                                                <input name="connection_type" class="primary_input_field" placeholder="Connection Type"
                                                       type="text" required>
                                                <span class="text-danger" id="connection_type_error"></span>
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Character Per Line') }} *</label>
                                                <input name="char_per_line" class="primary_input_field" placeholder="Character Per Line"
                                                       type="text" required>
                                                <span class="text-danger" id="char_per_line_error"></span>
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.IP') }} *</label>
                                                <input name="ip" class="primary_input_field" placeholder="IP"
                                                       type="text" required>
                                                <span class="text-danger" id="ip_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Port') }} *</label>
                                                <input name="port" class="primary_input_field" placeholder="Port"
                                                       type="text" required>
                                                <span class="text-danger" id="port_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Path') }} *</label>
                                                <input name="path" class="primary_input_field" placeholder="Path"
                                                       type="text" required>
                                                <span class="text-danger" id="path_error"></span>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"><i
                                                        class="ti-check"></i>{{ __('common.Add Printer') }}
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
                                <h4 class="modal-title">{{ __('common.Edit Printer') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="modelTypeEditForm">
                                    <div class="row">
                                        <input type="text" style="display: none;" class="edit_id">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                                <input name="name" class="primary_input_field name"
                                                       placeholder="Printer Name"
                                                       type="text" required>
                                                <span class="text-danger" id="edit_name_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Connection Type') }} *</label>
                                                <input name="connection_type" class="primary_input_field connection_type"
                                                       placeholder="Connection Type Name"
                                                       type="text" required>
                                                <span class="text-danger" id="edit_connection_type_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Character per line') }} *</label>
                                                <input name="char_per_line" class="primary_input_field char_per_line"
                                                       placeholder="Character per line"
                                                       type="text" required>
                                                <span class="text-danger" id="edit_char_per_line_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Ip') }} *</label>
                                                <input name="ip" class="primary_input_field ip"
                                                       placeholder="Ip"
                                                       type="text" required>
                                                <span class="text-danger" id="edit_ip_error"></span>
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.port') }} *</label>
                                                <input name="port" class="primary_input_field port"
                                                       placeholder="port"
                                                       type="text" required>
                                                <span class="text-danger" id="edit_port_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.path') }} *</label>
                                                <input name="path" class="primary_input_field path"
                                                       placeholder="path"
                                                       type="text" required>
                                                <span class="text-danger" id="edit_path_error"></span>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"><i
                                                        class="ti-check"></i>{{ __('common.Edit Printer') }}
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

                fetchData();

                $("#modelTypeForm").on("submit", function (event) {
                    event.preventDefault();
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        $("#" + formData[key].name + "_error").html("");
                    });
                    $.ajax({
                        url: "{{route("printer.store")}}",
                        data: formData,
                        type: "POST",
                        success: function (response) {
                            $("#Item_Details").modal("hide");
                            $("#modelTypeForm").trigger("reset");
                            fetchData();
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


                $("#printer_list").on("click", ".edit_model_type", function (event) {
                    let id = $(this).data("value");

                    let url = "{{ route('printer.edit', ":id") }}";
                    url = url.replace(":id", id)

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function (response) {
                            console.log(response);
                            $(".edit_id").val(response.id);
                            $(".name").val(response.name);
                            $(".connection_type").val(response.connection_type);
                            $(".char_per_line").val(response.char_per_line);
                            $(".ip").val(response.ip);
                            $(".port").val(response.port);
                            $(".path").val(response.path);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });


                $(document).on("submit", "#modelTypeEditForm", function (event) {
                    event.preventDefault();
                    let id = $(".edit_id").val();
                    let formData = $(this).serializeArray();
                    $.each(formData, function (key, message) {
                        $("#edit_" + formData[key].name + "_error").html("");
                    });

                    let url = "{{ route('printer.update', ":id") }}";
                    url = url.replace(":id", id)

                    $.ajax({
                        url: url,
                        data: formData,
                        type: "PUT",
                        dataType: "JSON",
                        success: function (response) {
                            $("#Item_Edit").modal("hide");
                            $("#modelTypeEditForm").trigger("reset");
                            fetchData();
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


                $("#printer_list").on("click", ".delete_model", function (event) {
                    event.preventDefault();
                    let id = $(this).data("value");

                     let url = "{{ route('printer.delete', ":id") }}";
                    url = url.replace(":id", id)

                    if (confirm("Are You Sure?")) {
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            success: function (response) {
                                fetchData();
                                toastr.success('Deleted')
                            },
                            error: function (error) {
                                toastr.success('Something Went Wrong');
                            }
                        });
                    }
                });


                function fetchData() {
                    $.ajax({
                        url: "{{route("printer.getdata")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#printer_list").html(response);
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
