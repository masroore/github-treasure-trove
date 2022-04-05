@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Bank Accounts') }}</h3>
                            @if(permissionCheck('char_accounts.store'))
                            <ul class="d-flex">
                                <li><a data-toggle="modal" data-target="#Item_Details"
                                       class="primary-btn radius_30px mr-10 fix-gr-bg" href="#">
                                        <i class="ti-plus"></i>{{ __('common.Add New') }} {{ __('account.Bank Accounts') }}</a></li>
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route('bank.account.csv_upload')}}"><i class="ti-export"></i>{{__('common.Upload Via CSV')}}</a></li>
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
                                    @include('account::bank_accounts.page_component.bank_accounts_list', ['bank_accounts' => $bank_accounts])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- create & update modal --}}
                @include('account::bank_accounts.page_component.create_modal')
                @include('account::bank_accounts.page_component.udpate_modal')
            </div>
        </div>
    </section>

    @include('backEnd.partials.delete_modal')
@endsection

@push('scripts')
    <script type="text/javascript">
     var baseUrl = $('#app_base_url').val();
        $(document).ready(function () {

            $(".as_sub_category").unbind().click(function () {
                $(".parent_chartAccount").toggle();
                $("#account_type").toggle();
            });


            $("#chart_account_form").on("submit", function (event) {
                event.preventDefault();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "{{route("bank_accounts.store")}}",
                    data: formData,
                    type: "POST",
                    success: function (response) {
                        $("#Item_Details").modal("hide");
                        $("#chart_account_form").trigger("reset");
                        $(".parent_chartAccount").hide();
                        chartAccountList();
                        toastr.success(response.success,"Success");
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
                let account = $(this).data("value");
                console.log(account.chart_account);
                $(".edit_id").val(account.id);
                $(".bank_name").val(account.bank_name);
                $(".branch_name").val(account.branch_name);
                $(".account_name").val(account.account_name);
                $(".account_no").val(account.account_no);
                $(".description").val(account.description);
                if (account.chart_account.status == 1) {
                    $(".active").attr("checked", true);
                } else {
                    $(".de_active").attr("checked", true);
                }
            });

            $(document).on("submit", "#ChartAccountEditForm", function (event) {
                event.preventDefault();
                let id = $(".edit_id").val();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#edit_" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "{{route('bank.account.update')}}",
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
                    url: "{{route("bank_accounts.create")}}",
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

            $("#chart_account_list").on("click", ".delete_ChartAccount", function (event) {
                event.preventDefault();
                let id = $(this).data("value");
                if (confirm("Are You Sure?")) {
                    $.ajax({
                        url: "{{route('bank.account.delete')}}",
                        type: "POST",
                        data: {
                            id : id,
                            _token : "{{csrf_token()}}",
                        },
                        success: function (response) {
                            toastr.success(response.success)
                            chartAccountList();
                        },
                        error: function (error) {
                            toastr.error(error.error);
                        }
                    });
                }
            });
        });

    </script>
@endpush
