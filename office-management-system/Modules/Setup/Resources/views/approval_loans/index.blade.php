 @extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Applied Loan') }}</h3>
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
                                    <th scope="col">{{ __('common.Name') }}</th>
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
                                            <td>{{ $loan->user != null ? $loan->user->name : "Removed" }}</td>
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
                                                        @if(permissionCheck('set_approval_applied_loan'))
                                                        <a href="#" onclick="ApplyLoanDetails({{ $loan->id }})" class="dropdown-item">{{__('common.View')}}</a>
                                                        @endif
                                                        @if ($loan->approval != 1)
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
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        function ApplyLoanDetails(el){
            $.post('{{ route('applied_loans.show') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#edit_form').html(data);
                $('#ApplyLoanview').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
