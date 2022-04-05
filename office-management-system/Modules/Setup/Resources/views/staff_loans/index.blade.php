@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Loan') }}</h3>
                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"  data-toggle="modal" data-target="#ApplyLoan"><i class="ti-plus"></i>{{ __('common.Apply For Loan') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('common.ID') }}</th>
                                    <th scope="col">{{ __('common.User') }}</th>
                                    <th scope="col">{{ __('common.Type') }}</th>
                                    <th scope="col">{{ __('common.Amount') }}</th>
                                    <th scope="col">{{ __('common.Monthly Installment') }}</th>
                                    <th scope="col">{{ __('common.Due') }}</th>
                                    <th scope="col">{{ __('common.Status') }}</th>
                                    <th scope="col">{{ __('common.Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($loans as $key => $loan)
                                    @if ($loan->user != null)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ @$loan->user->name }}</td>
                                            <td>{{ $loan->loan_type }}</td>
                                            <td>{{ single_price($loan->amount) }}</td>
                                            <td>{{ single_price($loan->monthly_installment) }}</td>
                                            @php
                                                $due = $loan->amount - $loan->paid_loan_amount;
                                            @endphp
                                            <td>{{ single_price($due) }}</td>
                                            <td>
                                                @if ($loan->approval == 0)
                                                    <span class="badge_3">{{__('common.Pending')}}</span>
                                                @elseif ($loan->approval == 1)
                                                    <span class="badge_1">{{__('common.Approved')}}</span>
                                                @else
                                                    <span class="badge_4">{{__('common.Cancelled')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        <a href="#" onclick="ApplyLoanView({{ $loan->id }})" class="dropdown-item">{{__('common.View')}}</a>
                                                        @if ($loan->approval != 1)
                                                            <a href="#" onclick="ApplyLoanEdit({{ $loan->id }})" class="dropdown-item">{{__('common.Edit')}}</a>
                                                            <a onclick="confirm_modal('{{route('apply_loans.destroy', $loan->id)}}');" class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="edit_form">

    </div>
@include('setup::staff_loans.create',['users' => $users])
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        $("#ApplyLoan_addForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("apply_loans.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#ApplyLoan").modal("hide");
                    $("#ApplyLoan_addForm").trigger("reset");
                    toastr.success("Loan has been applied Successfully");
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
        function getMonthlyInstallment()
        {
            var loan_amount = $('#amount').val();
            var total_month = $('#total_month').val();
            var monthly_installment = 0;
            monthly_installment = parseInt(loan_amount) / parseInt(total_month);
            $("#monthly_installment").val(monthly_installment.toFixed(2));
            $("#monthly_installment").val(monthly_installment.toFixed(2));
        }
        function ApplyLoanEdit(el){
            $.post('{{ route('apply_loans.edit') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#edit_form').html(data);
                $('#ApplyLoanEdit').modal('show');
                $('select').niceSelect();
            });
        }

        function ApplyLoanView(el){
            $.post('{{ route('apply_loans.show') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#edit_form').html(data);
                $('#ApplyLoanview').modal('show');
            });
        }
    </script>
@endpush
