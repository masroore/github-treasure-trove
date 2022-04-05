@extends('backEnd.master')
@section('page-title', app('general_setting')->site_title .' | Chart Of Accounts List')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Chart Of Accounts') }}</h3>
                            @if(permissionCheck('char_accounts.store'))
                            <ul class="d-flex">
                                <li><a data-toggle="modal" data-target="#Item_Details"
                                       class="primary-btn radius_30px mr-10 fix-gr-bg" href="#">
                                        <i class="ti-plus"></i>{{ __('common.Add New') }} {{ __('account.Chart Of Accounts') }}</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <div id="chart_account_list">
                                    @include('account::chart_accounts.page_component.chart_accounts_list', ['ChartOfAccountList' => $ChartOfAccountList])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- create & update modal --}}
                @include('account::chart_accounts.page_component.create_modal')
                @include('account::chart_accounts.page_component.udpate_modal')
                @include('account::chart_accounts.page_component.rename_model')
            </div>
        </div>

    </section>

    @include('backEnd.partials.delete_modal')
@endsection

@push('scripts')
    <script type="text/javascript">
     var baseUrl = $('#app_base_url').val();
        function get_data_modal(el)
        {
            $('#RenameAccount').modal('show');
            $('.account_id').val(el.id);
            $('.name').val(el.name);
        }
        $(document).ready(function () {

            $(".as_sub_category").unbind().click(function () {
                $(".parent_chartAccount").toggle();
                $("#account_type").toggle();
            });

            $(".as_sub_category_edit").unbind().click(function () {
                $(".edit_parent_chartAccount").toggle();
                parentChartAccount("edit_parent_chartAccount_list");
            });

            parentChartAccount();

            $("#chart_account_form").on("submit", function (event) {
                event.preventDefault();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "{{route("char_accounts.store")}}",
                    data: formData,
                    type: "POST",
                    success: function (response) {
                        $("#Item_Details").modal("hide");
                        $("#chart_account_form").trigger("reset");
                        $(".parent_chartAccount").hide();
                        chartAccountList();
                        parentChartAccount();
                        toastr.success("New Chart Account Added Successfully","Success");
                    },
                    error: function (error) {
                        if (error) {
                            $.each(error.responseJSON.errors, function (key, message) {
                                $("#" + key + "_error").html(message[0]);
                            });
                        }
                        toastr.warning("Something went wrong");
                    }

                });
            });


            $("#chart_account_list").on("click", ".edit_chart_account", function () {
                let id = $(this).data("value");

                $(".as_sub_category_edit").attr("checked", false);
                $(".edit_parent_chartAccount").hide();
                $.ajax({
                    url: baseUrl + "/account/chart-account/" + id + "/edit",
                    type: "GET",
                    success: function (response) {
                        $(".edit_id").val(response.id);
                        if (response.parent_id) {
                            $(".as_sub_category_edit").attr("checked", true);
                            $(".edit_parent_chartAccount").show();
                            parentChartAccount("edit_parent_chartAccount_list", response.parent_id,response.type);
                        }
                        $("#type_edit option[value=3]").attr('selected', 'selected');

                        $('#type_edit').niceSelect('update');
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

            $(document).on("submit", "#ChartAccountEditForm", function (event) {
                event.preventDefault();
                let id = $(".edit_id").val();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#edit_" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "/account/chart-account/update/" + id,
                    data: formData,
                    type: "POST",
                    dataType: "JSON",
                    success: function (response) {
                        $("#ChartAccount_Edit").modal("hide");
                        $("#ChartAccountEditForm").trigger("reset");
                        $(".active").attr("checked", false);
                        $(".de_active").attr("checked", false);
                        chartAccountList();
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

            function chartAccountList() {
                $.ajax({
                    url: "{{route("char_accounts.create")}}",
                    type: "GET",
                    dataType: "HTML",
                    success: function (response) {
                        $("#chart_account_list").html(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            function parentChartAccount(type = null, selected = null, editItem = null) {
                $.ajax({
                    url: "{{route("chart_accounts.parent")}}",
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        if (type) {
                            console.log(response)
                            accoutList = response.filter(item => item.type == editItem)
                            console.log(accoutList)
                            $("#" + type).html("");
                        } else {
                            accoutList = response;
                            $("#parent_chart_account_list").html("");
                        }
                        let parent_chartAccount = '';
                        parent_chartAccount += `<select name="parent_id" class="primary_select mb-15 parent_chart_account_list">`;
                        $.each(accoutList, function (key, item) {
                            if (selected && selected === item.id) {
                                parent_chartAccount += `<option selected value="${item.id}">${item.name}</option>`;
                            } else {
                                parent_chartAccount += `<option value="${item.id}">${item.name}</option>`;
                            }
                        });
                        parent_chartAccount += `<select>`;
                        if (type) {
                            console.log(type);
                            $("#" + type).html(parent_chartAccount);
                        } else {
                            $("#parent_chart_account_list").html(parent_chartAccount);
                        }
                        $('select').niceSelect();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

        });


    </script>
@endpush
